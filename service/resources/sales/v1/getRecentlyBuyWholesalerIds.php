<?php
namespace service\resources\sales\v1;

use common\models\SalesFlatOrder;

use service\message\core\getWholesalerRequest;
use service\message\core\getWholesalerResponse;
use service\resources\ResourceAbstract;

/**
 * Class getRecentlyBuyWholesalerIds
 * @package service\resources\sales\v1
 * 获取最近下过单的供应商
 */
class getRecentlyBuyWholesalerIds extends ResourceAbstract
{
    const WHOLESALER_NUM = 10;
    public function run($data)
    {
        /** @var getWholesalerRequest $request */
        $request = getWholesalerRequest::parseFromString($data);
        $response = self::response();

        $customer_id = $request->getCustomerId();


        $wholesaler_ids = SalesFlatOrder::find()->select('wholesaler_id')->where(['customer_id' => $customer_id])
            ->andWhere(['not in','state',[SalesFlatOrder::STATE_CANCELED,SalesFlatOrder::STATE_CLOSED]])
            ->limit(self::WHOLESALER_NUM)
            ->orderBy('created_at desc')
            ->groupBy('wholesaler_id');

        $wholesaler_ids = $wholesaler_ids->asArray()->all();

        foreach ($wholesaler_ids as $wholesaler_id){
            $response->appendWholesalerIds($wholesaler_id['wholesaler_id']);
        }

        return $response;
    }

    public static function request()
    {
        return new getWholesalerRequest();
    }

    public static function response()
    {
        return new getWholesalerResponse();
    }
}