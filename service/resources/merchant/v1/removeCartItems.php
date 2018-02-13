<?php
/**
 * Created by Jason.
 * Author: Jason Y. Wang
 * Date: 2016/1/27
 * Time: 12:24
 */

namespace service\resources\merchant\v1;

use service\message\customer\RemoveCartItemsRequest;
use service\models\ShoppingCart;
use service\resources\MerchantResourceAbstract;

/**
 * Author: Jason Y. Wang
 * Class updateItems
 * @package service\resources\customers
 */
class removeCartItems extends MerchantResourceAbstract
{
    public function run($data){
        /** @var RemoveCartItemsRequest $request */
        $request = RemoveCartItemsRequest::parseFromString($data);
        $customer = $this->_initCustomer($request);

        $cart = new ShoppingCart($customer);
        $cart->removeCartItems($request->getProducts());

    }

    public static function request(){
        return new RemoveCartItemsRequest();
    }

    public static function response(){
        // 实际上没有包体,头里面的code代表成功与否
        return true;
    }
}