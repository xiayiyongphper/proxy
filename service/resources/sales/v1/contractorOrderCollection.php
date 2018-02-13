<?php
namespace service\resources\sales\v1;

use common\models\SalesFlatOrder;
use framework\components\Date;
use framework\components\ToolsAbstract;
use framework\data\Pagination;
use service\components\ContractorPermission;
use service\components\Tools;
use service\message\contractor\OrderListRequest;
use service\message\sales\OrderCollectionResponse;
use service\resources\Exception;
use service\resources\ResourceAbstract;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/21
 * Time: 15:09
 */
class contractorOrderCollection extends ResourceAbstract
{
    const MAX_PAGE_SIZE = 10;

    public function run($data)
    {
        /** @var OrderListRequest $request */
        $request = OrderListRequest::parseFromString($data);
        $contractor_id = $request->getContractorId();
        $auth_token = $request->getAuthToken();

        $contractor = $this->_initContractor($contractor_id,$auth_token);

        if(!$contractor){
            Exception::contractorInitError();
        }
        //Tools::log($contractor->getRolePermission(),'wangyang.log');
        if(!ContractorPermission::orderTrackingCollectionPermission($contractor->getRolePermission())){
            Exception::contractorPermissionError();
        }

        $response = new OrderCollectionResponse();
        $pageSize = self::MAX_PAGE_SIZE;


        $keyword = $request->getKeyword();
        $wholesaler_ids = $request->getWholesalerId();
        $customer_ids = $request->getCustomerId();
        $status = $request->getStatus();
        $time_from = $request->getTimeFrom();
        $time_to = $request->getTimeTo();

        $date = new Date();
        $now = $date->date();
        $month_time_from = date('Y-m-d H:i:s', strtotime('-30 days',strtotime($now)));
        $month_time_to = $now;
        $conditions = ['between', 'created_at', $month_time_from, $month_time_to];

        if ($contractor->getRole() == self::COMMON_CONTRACTOR) {
            $conditions = ['and', ['contractor_id' => $contractor_id], $conditions];
        }else{
            $conditions = ['and', ['city' => $contractor->getCityList()], $conditions];
        }

        //时间查询
        if ($time_from && $time_to) {
            //客户端只传年月日
            $time_from = date('Y-m-d 16:00:00', strtotime('-1 day',strtotime($time_from)));
            $time_to = $time_to.' 16:00:00';
            $conditions = ['and', ['between', 'created_at', $time_from, $time_to], $conditions];
        }

        //关键字查询
        if ($keyword) {
            if (is_numeric($keyword)) {
                $conditions = ['and', ['like', 'increment_id', $keyword], $conditions];
            } else {
                $conditions = ['and', ['like', 'store_name', $keyword], $conditions];
            }
        }

        //供应商查询
        if (count($wholesaler_ids)) {
            $conditions = ['and', ['in', 'wholesaler_id', $wholesaler_ids], $conditions];
        }

        //超市查询
        if (count($customer_ids)) {
            $conditions = ['and', ['in', 'customer_id', $customer_ids], $conditions];
        }

        //状态查询
        if (count($status)) {
            $conditions = ['and', ['in', 'sales_flat_order.status', $status], $conditions];
        }

        $query = SalesFlatOrder::find()->where($conditions)->orderBy('created_at desc');
        $query->joinWith('orderstatus');

        //Tools::log($query->createCommand()->getRawSql(), 'wangyang.log');
        $pages = new Pagination(['totalCount' => $query->count()]);
        $pages->setCurPage($request->getPagination()->getPage());
        $pages->setPageSize($pageSize);

        $pagination = [
            'total_count' => $pages->totalCount,
            'page' => $pages->getCurPage(),
            'last_page' => $pages->getLastPageNumber(),
            'page_size' => $pages->getPageSize(),
        ];

        $orders = $query->offset($pages->getOffset())
            ->limit($pages->getLimit())
            ->all();

//        Tools::log($orders,'wangyang.log');

        $responseArray['items'] = [];
        foreach ($orders as $_order) {
            /** @var SalesFlatOrder $_order */
            if ($_order->orderstatus && $_order->orderstatus->label) {
                $statusLabel = $_order->orderstatus->label;
            } else {
                $statusLabel = $_order->status;
            }

            $order = [
                'order_id' => $_order->getPrimaryKey(),
                'increment_id' => $_order->increment_id,
                'wholesaler_id' => $_order->wholesaler_id,
                'wholesaler_name' => $_order->wholesaler_name,
                'store_name' => $_order->store_name,
                'status' => $_order->status,
                'status_label' => $statusLabel,
                'created_at' => $date->date('Y-m-d H:i', $_order->created_at),
                'grand_total' => $_order->grand_total
            ];
            $responseArray['items'][] = $order;
            $responseArray['pagination'] = $pagination;
        }

        $response->setFrom(ToolsAbstract::pb_array_filter($responseArray));
        return $response;
    }

    public static function request()
    {
        return new OrderListRequest();
    }

    public static function response()
    {
        return new OrderCollectionResponse();
    }
}