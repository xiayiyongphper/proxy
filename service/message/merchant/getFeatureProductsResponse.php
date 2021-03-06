<?php
namespace service\message\merchant;

// @@protoc_insertion_point(namespace:.service.message.merchant.getFeatureProductsResponse)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: merchant/getFeatureProductsResponse.proto
 *
 * -*- magic methods -*-
 *
 * @method array getProductList()
 * @method void appendProductList(\service\message\common\Product $value)
 */
class getFeatureProductsResponse extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.merchant.getFeatureProductsResponse)
  
  /**
   * @var array $product_list
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\Product
   **/
  protected $product_list;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.merchant.getFeatureProductsResponse)

  // @@protoc_insertion_point(class_scope:.service.message.merchant.getFeatureProductsResponse)

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
        "name"     => "product_list",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\Product',
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.merchant.getFeatureProductsResponse)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
