<?php
namespace service\message\sales;

// @@protoc_insertion_point(namespace:.service.message.sales.getCustomerCouponAvailableCountResponse)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: sales/getCustomerCouponAvailableCountResponse.proto
 *
 * -*- magic methods -*-
 *
 * @method string getCouponAvailableCount()
 * @method void setCouponAvailableCount(\string $value)
 */
class getCustomerCouponAvailableCountResponse extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.sales.getCustomerCouponAvailableCountResponse)
  
  /**
   * @var string $coupon_available_count
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $coupon_available_count;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.sales.getCustomerCouponAvailableCountResponse)

  // @@protoc_insertion_point(class_scope:.service.message.sales.getCustomerCouponAvailableCountResponse)

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
        "name"     => "coupon_available_count",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.sales.getCustomerCouponAvailableCountResponse)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
