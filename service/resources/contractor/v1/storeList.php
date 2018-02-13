<?php
namespace service\resources\contractor\v1;

use common\models\contractor\VisitRecords;
use common\models\CustomerLevel;
use common\models\CustomerType;
use common\models\LeContractor;
use common\models\LeCustomers;
use common\models\LeCustomersIntention;
use common\models\RegionArea;
use framework\data\Pagination;
use service\components\ContractorPermission;
use service\components\Tools;
use service\message\contractor\StoresListRequest;
use service\message\contractor\StoresResponse;
use service\message\contractor\visitedRecordsRequest;
use service\message\contractor\visitedRecordsResponse;
use service\models\common\Contractor;
use service\models\common\ContractorException;
use service\models\common\CustomerException;
use service\resources\Exception;
use yii\db\Expression;
use yii\db\mysql\QueryBuilder;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Class storeList
 * 店铺列表
 * @package service\resources\contractor\v1
 */
class storeList extends Contractor
{
    const PAGE_SIZE = 40;

    public $customers = null;
    public $pagination = null;
    /** @var  LeContractor $contractor */
    public $contractor = null;
    public $distance = null;
    public $request = null;
    public $city_list;

    public function run($data)
    {
        /** @var StoresListRequest $request */
        $request = StoresListRequest::parseFromString($data);
        $this->request = $request;
        $lat = $request->getLat() ?: 0;
        $lng = $request->getLng() ?: 0;
        $this->distance = new Expression('(ROUND(6378.138*2*ASIN(SQRT(POW(SIN((' . $lat . '*PI()/180-`lat`*PI()/180)/2),2)+COS(' . $lat . '*PI()/180)*COS(`lat`*PI()/180)*POW(SIN((' . $lng . '*PI()/180-`lng`*PI()/180)/2),2)))*1000)) as distance');

        $contractor = $this->initContractor($request);

        if (!ContractorPermission::contractorReviewStoreListPermission($this->role_permission)) {
            ContractorException::contractorPermissionError();
        }

        $this->city_list = array_filter(explode('|', $contractor->city_list));
        Tools::log($this->city_list,'wangyang.log');
        if (!$this->city_list) {
            ContractorException::contractorCityListEmpty();
        }

        if (!$contractor) {
            ContractorException::contractorInitError();
        }

        $this->contractor = $contractor;

        $list_type = $request->getListType() ?: 0;

        //Tools::log($list_type, 'wangyang.log');

        switch ($list_type) {
            case 0:
                $this->getAllCustomers();
                break;
            case 1:
                $this->getCustomers('customer');
                break;
            case 2:
                $this->getCustomers('customer_intention');
                break;
            case 3:
                $this->getReviewCustomers();
                break;
            default:
                $this->getCustomers('customer');
                break;
        }
        //levels && types
        $levels = CustomerLevel::find()->asArray()->all();
        $levels = Tools::conversionKeyArray($levels, 'entity_id');
        $types = CustomerType::find()->asArray()->all();
        $types = Tools::conversionKeyArray($types, 'entity_id');
        //Tools::log($this->customers,'wangyang.log');

        $responseData = [];
        /** @var LeCustomers $customer */
        foreach ($this->customers as $customer) {
            $type = [];
            $type_ids = array_filter(explode('|', $customer['type']));
            foreach ($type_ids as $type_id) {
                if (isset($types[$type_id]['type'])) {
                    $type[] = $types[$type_id]['type'];
                }
            }
            $type_name = implode(',', $type);
            if ($region = RegionArea::findOne(['entity_id' => $customer['area_id']])) {
                $area_name = $region->area_name;
            } else {
                $area_name = '';
            }

            if ($contractor->role != Contractor::COMMON_CONTRACTOR || $contractor->entity_id == $customer['contractor_id']) {
                $is_visit = 1;
            } else {
                $is_visit = 0;
            }

            $responseData['stores'][] = [
                'customer_id' => $customer['entity_id'],
                'store_name' => $customer['store_name'] ? $customer['store_name'] : $customer['phone'],
                'distance' => isset($customer['distance']) ? $customer['distance'] : -1,
                'level_name' => isset($levels[$customer['level']]['level']) ? $levels[$customer['level']]['level'] : '',
                'type_name' => $type_name,
                'lat' => $customer['lat'],
                'lng' => $customer['lng'],
                'customer_style' => $customer['intention'],
                'area_name' => $area_name,
                'contractor_id' => $customer['contractor_id'],
                'created_at' => $this->increase8Hours($customer['created_at']),
                'is_visit' => $is_visit,
            ];
        }
        $responseData['pagination'] = Tools::getPagination($this->pagination);
        $response = $this->response();
        $response->setFrom(Tools::pb_array_filter($responseData));
        return $response;
    }

    /**
     * getReviewCustomers
     * Author Jason Y. wang
     * 未审核超市
     */
    private function getReviewCustomers()
    {

        $request = $this->request;
        $customers = LeCustomers::find()->select(['*', new Expression('0 as intention')])
            ->where(['status' => 0])
            ->andWhere(['city' => $this->city_list])
            ->orderBy('created_at desc');
        $totalCount = $customers->count();
        $page = $request->getPagination()->getPage() ? $request->getPagination()->getPage() : 1;
        $pageSize = $request->getPagination()->getPageSize() ?: self::PAGE_SIZE;
        $pagination = new Pagination(['totalCount' => $totalCount]);
        $pagination->setPageSize($pageSize);
        $pagination->setCurPage($page);
        $customers = $customers->offset($pagination->getOffset())
            ->limit($pageSize)
            ->asArray()
            ->all();
        $this->customers = $customers;
        $this->pagination = $pagination;
    }

    /**
     * getCustomers
     * Author Jason Y. wang
     * 注册超市或意向超市
     * @param string $source
     * @return bool
     */
    private function getCustomers($source = 'customer')
    {
        $request = $this->request;
        $distance = $this->distance;
        Tools::log($this->contractor->role,'wangyang.log');
        Tools::log($this->city_list,'wangyang.log');
        Tools::log($source,'wangyang.log');
        if ($source == 'customer') {
            $customers = LeCustomers::find()->select(['*', $distance, new Expression('0 as intention')])
                ->where(['status' => 1]);
            //城市经理显示全部店铺
            if ($this->contractor->role == self::COMMON_CONTRACTOR) {
                $customers = $customers->andWhere(['contractor_id' => $this->contractor->entity_id]);
            } else {
                $customers = $customers->andWhere(['city' => $this->city_list]);
            }
            //Tools::log($customers->createCommand()->getRawSql(), 'wangyang.log');
        } else if ($source == 'customer_intention') {
            $customers = LeCustomersIntention::find()
                ->select(['*', new Expression('1 as intention'), $distance])
                ->andWhere(['>', 'lat', 0])
                ->andWhere(['>', 'lng', 0])
                ->andWhere(['status' => 0])
            ;
        } else if ($source == 'customer_review') {
            $customers = LeCustomers::find()->select(['*', $distance, new Expression('0 as intention')])->where(['status' => 0])
                ->andWhere(['>', 'lat', 0])->andWhere(['>', 'lng', 0]);
            //Tools::log($customers->createCommand()->getRawSql(), 'wangyang.log');
        } else {
            $customers = LeCustomers::find()->select(['*', $distance, new Expression('0 as intention')])
                ->andWhere(['>', 'lat', 0])->andWhere(['>', 'lng', 0]);
            //Tools::log($customers->createCommand()->getRawSql(), 'wangyang.log');
        }
        $customers = $customers->andWhere(['city' => $this->city_list]);
        $totalCount = $customers->count();
        $page = $request->getPagination()->getPage() ? $request->getPagination()->getPage() : 1;
        $pageSize = $request->getPagination()->getPageSize() ?: self::PAGE_SIZE;
        $pagination = new Pagination(['totalCount' => $totalCount]);
        $pagination->setPageSize($pageSize);
        $pagination->setCurPage($page);
        //排序，自己名下的排在前面
        $customers = $customers->offset($pagination->getOffset())
            ->orderBy(new Expression("(case when contractor_id={$this->contractor->entity_id} then 1 ELSE 4 END), distance asc"))
            ->limit($pageSize);
        //Tools::log($customers->createCommand()->getRawSql(), 'wangyang.log');
        $customers = $customers->asArray()
            ->all();
        $this->customers = $customers;
        $this->pagination = $pagination;
    }

    /**
     * getAllCustomers
     * Author Jason Y. wang
     * 注册超市和意向超市
     */
    private function getAllCustomers()
    {
        $request = $this->request;
        $distance = $this->distance;

        $customer_intention = LeCustomersIntention::find()->select(['entity_id', 'province', 'city',
            'district', 'area_id', 'address', 'detail_address', 'store_name', 'business_license_no', 'business_license_img', 'lat', 'lng',
            'phone', 'status', 'contractor_id', 'contractor', 'created_at', 'type', 'level', $distance, new Expression('1 as intention')])
            ->where(['status' => 0]);
        $customers_user = LeCustomers::find()->select(['entity_id', 'province', 'city',
            'district', 'area_id', 'address', 'detail_address', 'store_name', 'business_license_no', 'business_license_img', 'lat', 'lng',
            'phone', 'status', 'contractor_id', 'contractor', 'created_at', 'type', 'level', $distance, new Expression('0 as intention')])
            ->andWhere(['status' => 1]);
        //城市经理显示全部店铺
        if ($this->contractor->role == Contractor::COMMON_CONTRACTOR) {
            $customers_user = $customers_user->andWhere(['contractor_id' => $this->contractor->entity_id]);
        }
        $customers = (new Query())->from(['temp' => $customers_user->union($customer_intention, true)]);
        $customers = $customers->where(['city' => $this->city_list]);
        $totalCount = $customers->count('*', LeCustomers::getDb());
        $page = $request->getPagination()->getPage() ? $request->getPagination()->getPage() : 1;
        $pageSize = $request->getPagination()->getPageSize() ?: self::PAGE_SIZE;
        $pagination = new Pagination(['totalCount' => $totalCount]);
        $pagination->setPageSize($pageSize);
        $pagination->setCurPage($page);
        $customers = $customers->offset($pagination->getOffset())
            ->orderBy('distance asc')
            ->limit($pageSize);
        //Tools::log($customers->createCommand(LeCustomers::getDb())->getRawSql(), 'wangyang.log');
        $customers = $customers->all(LeCustomers::getDb());
        $this->customers = $customers;
        $this->pagination = $pagination;
    }

    public static function request()
    {
        return new StoresListRequest();
    }

    public static function response()
    {
        return new StoresResponse();
    }
}