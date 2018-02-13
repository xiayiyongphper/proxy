<?php
/**
 * Created by Jason.
 * Author: Jason Y. Wang
 * Date: 2016/1/22
 * Time: 14:17
 */

namespace service\models\common;


use common\components\UserTools;
use common\models\CustomerAuditLog;
use common\models\LeCustomers;
use common\models\LeCustomersAddressBook;
use service\message\common\Header;
use service\message\customer\CustomerResponse;
use service\resources\ResourceAbstract;

abstract class Customer extends ResourceAbstract
{
    //验证码过期时间
    const CODE_EXPIRATION_TIME = 60; //60s
    /** @var Header $header */
    protected $header;

    public function __construct()
    {
        
    }

    /**
     * Function: getCustomerModel
     * Author: Jason Y. Wang
     * 返回用户模型
     * @param $customerId
     * @param $token
     * @return LeCustomers|null
     */
    function getCustomerModel($customerId,$token){

        if(!$customerId){
            return null;
        }
        /* @var LeCustomers $customer */
        $customer = LeCustomers::findByCustomerId($customerId);

        if($customer){
            if($this->header->getSource() == 'pc'){
                return $customer;
            }elseif($token == $customer->auth_token){
                return $customer;
            }else{
                return null;
            }
        }else{
            return null;
        }

    }

    /**
     * Function: getCustomerInfo
     * Author: Jason Y. Wang
     * 返回用户信息
     * @param LeCustomers $customer
     * @return CustomerResponse
     */
    function  getCustomerInfo(LeCustomers $customer){
        $response = false;
        if ($customer) {
            $response = new CustomerResponse();
            $responseData = array(
                'customer_id' => $customer->getId(),
                'username' => $customer->username,
                'phone' => $customer->phone,
                'address' => $customer->address,
                'detail_address' => $customer->detail_address,
                'area_id' => $customer->area_id,
                'store_name' => $customer->store_name,
                'auth_token' => $customer->auth_token,
                'lat' => $customer->lat,
                'lng' => $customer->lng,
                'status' => $customer->status,
                'store_area' => $customer->store_area,
                'storekeeper' => $customer->storekeeper,
                'province' => $customer->province,
                'city' => $customer->city,
                'district' => $customer->district,

            );

            //是否填写资料
            if($customer->store_name){
                //已填写
                $responseData['fill_user_info'] = 1;
            }else{
                //未填写
                $responseData['fill_user_info'] = 0;
            }
            //返回收货人信息
            /* @var $addressBook LeCustomersAddressBook */
            $addressBook = LeCustomersAddressBook::findReceiverCustomerId(['customer_id' => $customer->getId()]);
            if($addressBook && $addressBook->getId()){
                $responseData['receiver_name'] = $addressBook->receiver_name;
                $responseData['receiver_phone'] = $addressBook->phone;
            }
            //审核不通过原因
            $customer_audit_log = CustomerAuditLog::find()
                ->where(['customer_id' => $customer->getId(),'type'=>1])
                ->orderBy(['created_at' => SORT_DESC ])->one();
            if($customer_audit_log){
                $responseData['not_pass_reason'] = $customer_audit_log['content'];
            }else{
                $responseData['not_pass_reason'] = '';
            }
            $responseData['orders_total_price'] = $customer->orders_total_price;
            //$responseData = array_filter($responseData);  //把0也过滤掉了，已后优化
            UserTools::formatFormData($responseData);
            $response->setFrom($responseData);
        }

        return $response;
    }
}