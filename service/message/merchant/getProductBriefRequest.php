<?php
namespace service\message\merchant;

// @@protoc_insertion_point(namespace:.service.message.merchant.getProductBriefRequest)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: merchant/getProductBriefRequest.proto
 *
 * -*- magic methods -*-
 *
 * @method string getCity()
 * @method void setCity(\string $value)
 * @method array getProductIds()
 * @method void appendProductIds(\string $value)
 */
class getProductBriefRequest extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.merchant.getProductBriefRequest)
  
  /**
   * @var string $city
   * @tag 1
   * @label required
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $city;
  
  /**
   * @var array $product_ids
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $product_ids;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.merchant.getProductBriefRequest)

  // @@protoc_insertion_point(class_scope:.service.message.merchant.getProductBriefRequest)

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
        "name"     => "city",
        "required" => true,
        "optional" => false,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "product_ids",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.merchant.getProductBriefRequest)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}