<?php
namespace service\resources\sales\v1;

use common\models\salesrule\UserCoupon;
use framework\components\ToolsAbstract;
use service\components\Proxy;
use service\components\Tools;
use service\message\sales\OrderReviewRequest;
use service\message\sales\OrderReviewResponse;
use service\models\Product;
use service\models\sales\Quote;
use service\models\VarienObject;
use service\resources\Exception;
use service\resources\ResourceAbstract;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/21
 * Time: 15:09
 */
class orderReview1 extends ResourceAbstract
{
    const DEFAULT_PAGE_SIZE = 10;

    public function run($data)
    {
        /** @var OrderReviewRequest $request */
        $request = OrderReviewRequest::parseFromString($data);

        $customer = $this->_initCustomer($request, true);
        $response = new OrderReviewResponse();
        $storeProducts = $this->prepareForMultiCreate($request);
        $storeIds = array_keys($storeProducts);

        $quotes = array();
        //多店铺
        foreach ($storeProducts as $wholesalerId => $products) {
            $quote = new Quote();
            $quote->setCustomerId($request->getCustomerId());
            $quote->setCouponId($request->getCouponId());
            $wholesaler = Proxy::getWholesaler($wholesalerId, $this->getTraceId(), $customer);

            if (!$wholesaler->getWholesalerId()) {
                Exception::storeNotExisted();
            }

            $quote->setWholesaler($wholesaler);
            $productIds = array_keys($products);
            $productResponse = Proxy::getProducts($customer->getCity(), $productIds, $this->getTraceId());
            foreach ($productResponse->getProductList() as $product) {
                /** @var \service\message\common\Product $product */
                $instance = new Product($product);
                $buyRequest = new VarienObject($products[$instance->getProductId()]);
                if (!$instance->isOnSale() || !$instance->checkQty($buyRequest->getNum())) {
                    $topicText = $instance->getQty() > 0 ? Exception::NEW_CATALOG_PRODUCT_SOLD_OUT_TEXT2 : Exception::NEW_CATALOG_PRODUCT_SOLD_OUT_TEXT1;
                    $productName = sprintf($topicText, $instance->getName());
                    throw new \Exception($productName, Exception::CATALOG_PRODUCT_SOLD_OUT);
                }
                $instance->checkRestrictDaily($buyRequest->getNum(), $customer, true);
                $quote->addProduct($instance, $buyRequest);

            }

            if (count($storeIds) > 1) {
                $quote->setIsMultiStore(true);
            } else {
                $quote->setIsMultiStore(false);
            }

            $quote->collectTotals(true);
            $addressId = 0;
            $quote->setAddress('');
            $quote->setAddressId($addressId);
            $quote->setCustomerId($request->getCustomerId());
            $quotes[] = $quote;
        }

        $result = new VarienObject();
        $result->setGrandTotal(0);
        $result->setSubtotal(0);
        $result->setShippingAmount(0);
        $result->setDiscountAmount(0);
        $result->setCouponDiscountAmount(0);
        $items = [];
        $tags = [];
        $availableCoupons = null;
        $unavailableCoupons = null;
        $couponId = 0;
        $couponText = UserCoupon::NOT_AVAILABLE_COUPON_TEXT;
        //多店铺
        foreach ($quotes as $_quote) {
            /* @var $_quote Quote */
            /*check mini trade amount */
            $_minTradeAmount = $_quote->getWholesaler()->getMinTradeAmount();

            $count = Tools::orderCountToday($customer->getCustomerId(), $_quote->getWholesaler()->getWholesalerId());
            if ($count == 0) {
                if ($_minTradeAmount > 0 && $_quote->getSubtotal() < $_minTradeAmount) {
                    Exception::notSatisfyMinTradeAmount($_minTradeAmount);
                }
            }
            $result->setGrandTotal($_quote->getGrandTotal() + $result->getGrandTotal());
            $result->setCustomerId($_quote->getCustomerId());
            $result->setShippingAmount($_quote->getShippingAmount() + $result->getShippingAmount());
            $result->setDiscountAmount($_quote->getDiscountAmount() + $result->getDiscountAmount());
            $result->setCouponDiscountAmount($_quote->getCouponDiscountAmount() + $result->getCouponDiscountAmount());
            $result->setSubtotal($_quote->getSubtotal() + $result->getSubtotal());
            $items[] = $_quote->getStoreProductDetail();
            $tags = $_quote->getTags();
            $availableCoupons = $_quote->getAvailableCoupons();
            $unavailableCoupons = $_quote->getUnavailableCoupons();
            $couponId = $_quote->getCouponId();

            if ($_quote->getGiftDiscount() === true) {
                $couponText = '已享赠品';
            }

            if ($_quote->getCouponDiscountAmount() > 0) {
                $couponText = sprintf('已减%s元', $_quote->getCouponDiscountAmount());
            }
        }

        if ($couponId == UserCoupon::NOT_USE_COUPON) {
            $couponText = UserCoupon::NOT_USE_COUPON_TEXT;
        }

        $result->setItems($items);

        // 钱包
        $balance = $request->getBalance();
        if ($balance) {
            // 用户钱包余额
            $customer_balance = $customer->getBalance();
            if ($balance == -1 || $balance > $customer_balance) {
                // 第一次进来或者大于余额了,则使用全部余额。
                $balance = $customer_balance;
            }

            // 用户今天可用余额
            $todayAvailable = Tools::getBalanceDailyLimit($customer->getCustomerId());
            if ($balance > $todayAvailable) {
                $balance = $todayAvailable;
            }

            // 超订单金额使用则砍掉
            if ($balance > $result->getGrandTotal()) {
                $balance = $result->getGrandTotal();
            }

            // 钱包余额优先抵扣grand_total的零钱,再抵扣整数块。2016年08月22日10:10:19 zgr
            // 此时的balance是钱包可用的最高额
            if ($balance > 0) {
                $gt = $result->getGrandTotal();// 当前的订单总额
                $decimal = $gt - floor($gt);
                if ($balance >= $decimal) {
                    $balance = floor($balance - $decimal) + $decimal;
                } else {
                    $balance = 0;
                }
            }

            // 扣减钱包余额
            if ($balance > 0) {
                $result->setGrandTotal($result->getGrandTotal() - $balance);
            }
        }


        $responseData = [
            'balance' => $balance,
            'grand_total' => $result->getGrandTotal(),
            'base_total' => $result->getSubtotal(),
            'shipping_amount' => $result->getShippingAmount(),
            'discount_amount' => $result->getDiscountAmount(),
            'coupon_discount_amount' => $result->getCouponDiscountAmount(),
            'customer_id' => $request->getCustomerId(),
            'items' => $items,
            'available_coupons' => $availableCoupons,
            'unavailable_coupons' => $unavailableCoupons,
            'coupon_id' => $couponId,
            'coupon_text' => $couponText,
        ];

        if (count($tags) > 0) {
            $responseData['applied_rules'] = [
                'group_name' => '已享优惠',
                'tags' => $tags
            ];
        }

        $response->setFrom(Tools::pb_array_filter($responseData));
        return $response;
    }

    /**
     * 获取生成订单的产品，进行店铺区分，以便拆分订单
     * @param OrderReviewRequest $request
     * @return array
     * @throws Exception
     */
    protected function prepareForMultiCreate($request)
    {
        //prepare items
        $items = $request->getItems();
        $array = array();
        if (is_array($items) && count($items) > 0) {
            foreach ($items as $item) {
                /** @var \service\message\common\Product $item */
                $wholesalerId = $item->getWholesalerId();
                if (!$wholesalerId) {
                    Exception::storeNotExisted();
                }
                if (!isset($array[$wholesalerId])) {
                    $array[$wholesalerId] = array();
                }
                $array[$wholesalerId][$item->getProductId()] = $item->toArray();
            }
            if (count(array_keys($array)) > 1) {
                Exception::multiStoreNotAllowed();
            }
        } else {
            Exception::emptyShoppingCart();
        }
        return $array;
    }

    public static function request()
    {
        return new OrderReviewRequest();
    }

    public static function response()
    {
        return new OrderReviewResponse();
    }
}