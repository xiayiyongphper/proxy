<?php
/**
 * Created by PhpStorm.
 * User: zgr0629
 * Date: 25/1/2016
 * Time: 11:19 AM
 */
namespace service\resources\merchant\v1;

use common\models\LeMerchantStore;
use framework\data\Pagination;
use service\components\ContractorPermission;
use service\components\Tools;
use service\message\merchant\ContractorMerchantRequest;
use service\message\merchant\ContractorMerchantResponse;
use service\resources\MerchantException;
use service\resources\MerchantResourceAbstract;


class getMerchantByContractor extends MerchantResourceAbstract
{
    const PAGE_SIZE = 20;
    public function run($data)
    {
        /** @var ContractorMerchantRequest $request */
        $request = $this->request()->parseFromString($data);
        $contractor = $this->_initContractor($request->getContractorId(),$request->getAuthToken());
        $city_list = $contractor->getCityList();

        if(!$contractor){
            MerchantException::contractorInitError();
        }

        if(!ContractorPermission::contractorMerchantCollectionPermission($contractor->getRolePermission())){
            MerchantException::contractorPermissionError();
        }

        $page_num = $request->getPagination()->getPage()?:1;
        $page_size = $request->getPagination()->getPageSize()?:self::PAGE_SIZE;

        if($city_list){
            $merchant_query = LeMerchantStore::find()->where(['city' => $city_list]);
        }else{
            $merchant_query = LeMerchantStore::find()->where(['city' => $contractor->getCity()]);
        }

        $pages = new Pagination(['totalCount' => $merchant_query->count()]);
        $pages->setCurPage($page_num);
        $pages->setPageSize($page_size);

        $merchant_all = $merchant_query->offset($pages->getOffset())->limit($page_size)->all();

        $pagination = [
            'total_count' => $pages->totalCount,
            'page' => $page_num,
            'last_page' => $pages->getLastPageNumber(),
            'page_size' => $page_size,
        ];

        $merchant = [];
        /** @var LeMerchantStore $merchant_one */
        foreach ($merchant_all as $merchant_one) {
            $merchant_tmp['key'] = $merchant_one->entity_id;
            $merchant_tmp['value'] = $merchant_one->store_name;
            array_push($merchant, $merchant_tmp);
        }

        $data = [
            'merchant' => $merchant,
            'pagination' => $pagination
        ];
        $response = $this->response();
        $response->setFrom(Tools::pb_array_filter($data));
        return $response;
    }

    public static function request()
    {
        return new ContractorMerchantRequest();
    }

    public static function response()
    {
        return new ContractorMerchantResponse();
    }
}