<?php
namespace service\message\customer;

// @@protoc_insertion_point(namespace:.service.message.customer.CustomerBalanceLogRequest)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: customer/CustomerBalanceLogRequest.proto
 *
 * -*- magic methods -*-
 *
 * @method string getCustomerId()
 * @method void setCustomerId(\string $value)
 * @method string getAuthToken()
 * @method void setAuthToken(\string $value)
 * @method string getPage()
 * @method void setPage(\string $value)
 */
class CustomerBalanceLogRequest extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.customer.CustomerBalanceLogRequest)
  
  /**
   * @var string $customer_id
   * @tag 1
   * @label required
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $customer_id;
  
  /**
   * @var string $auth_token
   * @tag 2
   * @label required
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $auth_token;
  
  /**
   * @var string $page
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $page;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.customer.CustomerBalanceLogRequest)

  // @@protoc_insertion_point(class_scope:.service.message.customer.CustomerBalanceLogRequest)

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
        "required" => true,
        "optional" => false,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "auth_token",
        "required" => true,
        "optional" => false,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(3, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "page",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => 1,
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.customer.CustomerBalanceLogRequest)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
