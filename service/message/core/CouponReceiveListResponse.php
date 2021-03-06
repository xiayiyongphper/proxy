<?php
namespace service\message\core;

// @@protoc_insertion_point(namespace:.service.message.core.CouponReceiveListResponse)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: core/CouponReceiveListResponse.proto
 *
 * -*- magic methods -*-
 *
 * @method array getCouponReceive()
 * @method void appendCouponReceive(\service\message\common\CouponReceive $value)
 */
class CouponReceiveListResponse extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.core.CouponReceiveListResponse)
  
  /**
   * @var array $coupon_receive
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\CouponReceive
   **/
  protected $coupon_receive;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.core.CouponReceiveListResponse)

  // @@protoc_insertion_point(class_scope:.service.message.core.CouponReceiveListResponse)

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
        "name"     => "coupon_receive",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\CouponReceive',
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.core.CouponReceiveListResponse)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
