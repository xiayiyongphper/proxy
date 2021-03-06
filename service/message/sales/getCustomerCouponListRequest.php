<?php
namespace service\message\sales;

// @@protoc_insertion_point(namespace:.service.message.sales.getCustomerCouponListRequest)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: sales/getCustomerCouponListRequest.proto
 *
 * -*- magic methods -*-
 *
 * @method string getCustomerId()
 * @method void setCustomerId(\string $value)
 * @method string getAuthToken()
 * @method void setAuthToken(\string $value)
 * @method string getExpireList()
 * @method void setExpireList(\string $value)
 * @method \service\message\common\Pagination getPagination()
 * @method void setPagination(\service\message\common\Pagination $value)
 */
class getCustomerCouponListRequest extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.sales.getCustomerCouponListRequest)
  
  /**
   * @var string $customer_id
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $customer_id;
  
  /**
   * @var string $auth_token
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $auth_token;
  
  /**
   * @var string $expire_list
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $expire_list;
  
  /**
   * @var \service\message\common\Pagination $pagination
   * @tag 4
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   **/
  protected $pagination;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.sales.getCustomerCouponListRequest)

  // @@protoc_insertion_point(class_scope:.service.message.sales.getCustomerCouponListRequest)

  /**
   * get descriptor for protocol buffers
   * 
   * @return \ProtocolBuffersDescriptor
   */
  public static function getDescriptor()
  {
    static $descriptor;
    
    if (!isset($descriptor)) {
      $desc = new \ProtocolBuffers\DescriptorBuilder();
      $desc->addField(1, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "customer_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "auth_token",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(3, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "expire_list",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(4, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "pagination",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\Pagination',
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.sales.getCustomerCouponListRequest)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
