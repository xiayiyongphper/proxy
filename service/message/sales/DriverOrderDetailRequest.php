<?php
namespace service\message\sales;

// @@protoc_insertion_point(namespace:.service.message.sales.DriverOrderDetailRequest)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: sales/DriverOrderDetailRequest.proto
 *
 * -*- magic methods -*-
 *
 * @method string getIncrementId()
 * @method void setIncrementId(\string $value)
 * @method string getOrderId()
 * @method void setOrderId(\string $value)
 */
class DriverOrderDetailRequest extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.sales.DriverOrderDetailRequest)
  
  /**
   * @var string $increment_id
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $increment_id;
  
  /**
   * @var string $order_id
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $order_id;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.sales.DriverOrderDetailRequest)

  // @@protoc_insertion_point(class_scope:.service.message.sales.DriverOrderDetailRequest)

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
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "increment_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "order_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.sales.DriverOrderDetailRequest)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
