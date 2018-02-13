<?php
namespace service\resources\contractor\v1;

use common\models\LeCustomers;
use common\models\LeCustomersIntention;
use framework\data\Pagination;
use service\components\ContractorPermission;
use service\components\Tools;
use service\message\contractor\searchStoresRequest;
use service\message\contractor\StoresResponse;
use service\models\common\Contractor;
use service\models\common\ContractorException;
use service\models\common\CustomerException;
use yii\db\Expression;
use yii\db\Query;

/**
 * Created by PhpStorm.
 * User: henryzhu
 * Date: 16-7-25
 * Time: 上午11:43
 * Email: henryzxj1989@gmail.com
 */

/**
 * Class searchStores
 * @package service\resources\contractor\v1
 */
class searchStores extends Contractor
{
    const PAGE_SIZE = 10;

    public function run($data)
    {
        /** @var searchStoresRequest $request */
        $request = searchStoresRequest::parseFromString($data);
        $response = self::response();
        $contractor = $this->initContractor($request);

        $city_list = array_filter(explode('|', $contractor->city_list));

        if (!$city_list) {
            ContractorException::contractorCityListEmpty();
        }

        if (!ContractorPermission::contractorStoreSearchPermission($this->role_permission)) {
            ContractorException::contractorPermissionError();
        }

        Tools::log($contractor, 'wangyang.log');
        if ($request->has('city') || $request->has('keyword')) {
            $customer_intention = LeCustomersIntention::find()->select(['entity_id', 'province', 'city',
                'district', 'area_id', 'address', 'detail_address', 'store_name', 'business_license_no', 'business_license_img', 'lat', 'lng',
                'phone', 'status', 'contractor_id', 'contractor', 'created_at', 'type', 'level', new Expression('1 as intention')])
                ->andWhere(['status' => 0]);
            $customer_user = LeCustomers::find()->select(['entity_id', 'province', 'city',
                'district', 'area_id', 'address', 'detail_address', 'store_name', 'business_license_no', 'business_license_img', 'lat', 'lng',
                'phone', 'status', 'contractor_id', 'contractor', 'created_at', 'type', 'level', new Expression('0 as intention')])
                ->andWhere(['status' => 1]);
            //城市经理显示全部店铺
            if ($contractor->role == self::COMMON_CONTRACTOR) {
                $customer_intention = $customer_intention->andWhere(['contractor_id' => $contractor->entity_id]);
                $customer_user = $customer_user->andWhere(['contractor_id' => $contractor->entity_id]);
            } else {
                $customer_intention = $customer_intention->andWhere(['city' => $city_list]);
                $customer_user = $customer_user->andWhere(['city' => $city_list]);
            }

            $customers = (new Query())->from(['temp' => $customer_user->union($customer_intention, true)]);
            $customers = $customers->andWhere(['city' => $city_list]);

            if ($request->has('keyword')) {
                $keyword = trim($request->getKeyword());
                $customers->andWhere(['like', 'store_name', "$keyword"]);
            }
            $totalCount = $customers->count('*', LeCustomers::getDb());
            $page = $request->getPagination()->getPage() ? $request->getPagination()->getPage() : 1;
            $pagination = new Pagination(['totalCount' => $totalCount]);
            $pagination->setPageSize(self::PAGE_SIZE);
            $pagination->setCurPage($page);
            $customers = $customers->offset($pagination->getOffset())
                ->limit(self::PAGE_SIZE)
                ->all(LeCustomers::getDb());

            $responseData = [
                'pagination' => Tools::getPagination($pagination),
                'stores' => [],
            ];
            /** @var LeCustomers $customer */
            foreach ($customers as $customer) {
                if ($contractor->role != self::COMMON_CONTRACTOR || $contractor->entity_id == $customer['contractor_id']) {
                    $is_visit = 1;
                } else {
                    $is_visit = 0;
                }
                $responseData['stores'][] = [
                    'store_name' => $customer['store_name'],
                    'customer_id' => $customer['entity_id'],
                    'customer_style' => $customer['intention'],
                    'address' => $customer['address'],
                    'detail_address' => $customer['detail_address'],
                    'is_visit' => $is_visit,
                ];
            }
            $response->setFrom(Tools::pb_array_filter($responseData));
        }
        return $response;
    }

    public static function request()
    {
        return new searchStoresRequest();
    }

    public static function response()
    {
        return new StoresResponse();
    }
}