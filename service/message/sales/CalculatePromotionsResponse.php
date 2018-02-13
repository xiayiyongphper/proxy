<?php
namespace service\message\sales;

// @@protoc_insertion_point(namespace:.service.message.sales.CalculatePromotionsResponse)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: sales/CalculatePromotionsResponse.proto
 *
 * -*- magic methods -*-
 *
 * @method array getDiscountNote()
 * @method void appendDiscountNote(\service\message\common\DiscountNote $value)
 */
class CalculatePromotionsResponse extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.sales.CalculatePromotionsResponse)
  
  /**
   * @var array $discount_note
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\DiscountNote
   **/
  protected $discount_note;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.sales.CalculatePromotionsResponse)

  // @@protoc_insertion_point(class_scope:.service.message.sales.CalculatePromotionsResponse)

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
        "name"     => "discount_note",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\DiscountNote',
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.sales.CalculatePromotionsResponse)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
