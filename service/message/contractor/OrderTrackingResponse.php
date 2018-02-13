<?php
namespace service\message\contractor;

// @@protoc_insertion_point(namespace:.service.message.contractor.OrderTrackingResponse)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: contractor/OrderTrackingResponse.proto
 *
 * -*- magic methods -*-
 *
 * @method array getOrderTracking()
 * @method void appendOrderTracking(\service\message\common\KeyValueItem $value)
 */
class OrderTrackingResponse extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.contractor.OrderTrackingResponse)
  
  /**
   * @var array $order_tracking
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\KeyValueItem
   **/
  protected $order_tracking;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.contractor.OrderTrackingResponse)

  // @@protoc_insertion_point(class_scope:.service.message.contractor.OrderTrackingResponse)

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
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "order_tracking",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\KeyValueItem',
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.contractor.OrderTrackingResponse)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}