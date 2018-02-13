<?php
/**
 * Created by Jason Y. wang
 * User: wangyang
 * Date: 16-7-21
 * Time: 下午5:29
 */

namespace service\resources\contractor\v1;


use common\components\UserTools;
use common\models\contractor\VisitRecords;
use common\models\LeContractor;
use common\models\RegionArea;
use service\components\ContractorPermission;
use service\components\Tools;
use service\message\contractor\GetStoreInfoRequest;
use service\message\contractor\GetStoreInfoResponse;
use service\models\common\Contractor;
use service\models\common\ContractorException;
use service\models\common\CustomerException;

class getStoreInfo extends Contractor
{
    public function run($data)
    {
        /** @var GetStoreInfoRequest $request */
        $request = GetStoreInfoRequest::parseFromString($data);
        $response = new GetStoreInfoResponse();
        /** @var LeContractor $contractor */
        $contractor = $this->initContractor($request);

        if(!ContractorPermission::contractorStoreDetailCreatePermission($this->role_permission)){
            ContractorException::contractorPermissionError();
        }

        $customer_id = $request->getCustomerId();
        $customer_style = $request->getCustomerStyle();
        $store = $this->getStoreInfoV2($customer_id,$customer_style);
        //Tools::log($contractor,'wangyang.log');
        //Tools::log($store,'wangyang.log');

        if($contractor->role == Contractor::COMMON_CONTRACTOR && $store['contractor_id'] != $contractor->entity_id){
                ContractorException::contractorStoreInfoForbidden();
        }

        //Tools::log($store,'wangyang.log');
        if($region = RegionArea::findOne(['entity_id' => $store['area_id']])){
            $area_name = $region->area_name;
            $store['area_name'] = $area_name;
        }

        $responseData['store'] = $store;
        $responseData['store']['contractor'] = $store['contractor'];
        $responseData['store']['created_at'] = $store['created_at'];
        $visitRecords = VisitRecords::find()->where(['customer_id' => $customer_id])->andWhere(['is_intended' => $customer_style])->orderBy('created_at desc');
        $records_count = $visitRecords->count();
        /** @var VisitRecords $visitRecord */
        $visitRecord = $visitRecords->one();
        if($visitRecord) {
            $finally_record = [
                'contractor_name' => $visitRecord->contractor_name,
                'visited_at' => $visitRecord->visited_at,
            ];
            $responseData['records_count'] = $records_count;
            $responseData['final_record'] = $finally_record;

        }
        //注册超市才会请求订单信息
        if($customer_style == 0){
            $customer_orders_data = UserTools::getCustomerOrderDataByProxy($customer_id);
            if($customer_orders_data){
                $customer_orders = $customer_orders_data->getOrderInfo();
                foreach ($customer_orders as $customer_order){
                    $response->appendOrderInfo($customer_order);
                }
            }
        }
        $response->setFrom(Tools::pb_array_filter($responseData));
        return $response;
    }

    public static function request(){
        return new GetStoreInfoRequest();
    }

    public static function response(){
        return new GetStoreInfoResponse();
    }
    
}