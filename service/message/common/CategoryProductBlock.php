<?php
namespace service\message\common;

// @@protoc_insertion_point(namespace:.service.message.common.CategoryProductBlock)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: common/CategoryProductBlock.proto
 *
 * -*- magic methods -*-
 *
 * @method \service\message\common\CategoryNode getCategory()
 * @method void setCategory(\service\message\common\CategoryNode $value)
 * @method array getProductList()
 * @method void appendProductList(\service\message\common\Product $value)
 */
class CategoryProductBlock extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.common.CategoryProductBlock)
  
  /**
   * @var \service\message\common\CategoryNode $category
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   **/
  protected $category;
  
  /**
   * @var array $product_list
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\Product
   **/
  protected $product_list;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.common.CategoryProductBlock)

  // @@protoc_insertion_point(class_scope:.service.message.common.CategoryProductBlock)

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
        "name"     => "category",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\CategoryNode',
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "product_list",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\Product',
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.common.CategoryProductBlock)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
