<?php
/**
 * Created by Jason Y. wang
 * User: wangyang
 * Date: 16-7-21
 * Time: 下午5:29
 */

namespace service\resources\contractor\v1;

use common\models\contractor\ContractorMarkPriceHistory;
use service\message\contractor\MarkPriceRequest;
use service\models\common\Contractor;
use service\models\common\ContractorException;

class markPrice extends Contractor
{
    public function run($data)
    {
        /** @var MarkPriceRequest $request */
        $request = MarkPriceRequest::parseFromString($data);
        $contractor = $this->initContractor($request);
        $product_id = $request->getProductId();
        $price = $request->getPrice();
        $markPrice = new ContractorMarkPriceHistory();
        $markPrice->contractor_id = $contractor->entity_id;
        $markPrice->contractor_name = $contractor->name;
        $markPrice->city = $contractor->city;
        $markPrice->mark_price_product_id = $product_id;
        $markPrice->price = $price;
        $markPrice->created_at = date('Y-m-d H:i:s');
        if (!$markPrice->save()) {
            ContractorException::contractorSystemError();
        }
        return true;
    }

    public static function request()
    {
        return new MarkPriceRequest();
    }

    public static function response()
    {
        return true;
    }
}