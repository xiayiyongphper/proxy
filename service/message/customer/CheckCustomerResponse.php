<?php
namespace service\message\customer;

// @@protoc_insertion_point(namespace:.service.message.customer.CheckCustomerResponse)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: customer/CheckCustomerResponse.proto
 *
 * -*- magic methods -*-
 *
 * @method string getCode()
 * @method void setCode(\string $value)
 */
class CheckCustomerResponse extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.customer.CheckCustomerResponse)
  
  /**
   * @var string $code
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $code;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.customer.CheckCustomerResponse)

  // @@protoc_insertion_point(class_scope:.service.message.customer.CheckCustomerResponse)

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
        "name"     => "code",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.customer.CheckCustomerResponse)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
