<?php
namespace service\message\merchant;

// @@protoc_insertion_point(namespace:.service.message.merchant.searchProductResponse)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: merchant/searchProductResponse.proto
 *
 * -*- magic methods -*-
 *
 * @method array getProductList()
 * @method void appendProductList(\service\message\common\Product $value)
 * @method \service\message\common\Pagination getPages()
 * @method void setPages(\service\message\common\Pagination $value)
 * @method \service\message\common\CategoryNode getCategory()
 * @method void setCategory(\service\message\common\CategoryNode $value)
 * @method array getWords()
 * @method void appendWords(\string $value)
 * @method array getWholesalerList()
 * @method void appendWholesalerList(\service\message\common\Store $value)
 */
class searchProductResponse extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.merchant.searchProductResponse)
  
  /**
   * @var array $product_list
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\Product
   **/
  protected $product_list;
  
  /**
   * @var \service\message\common\Pagination $pages
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   **/
  protected $pages;
  
  /**
   * @var \service\message\common\CategoryNode $category
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   **/
  protected $category;
  
  /**
   * @var array $words
   * @tag 4
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $words;
  
  /**
   * @var array $wholesaler_list
   * @tag 5
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\Store
   **/
  protected $wholesaler_list;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.merchant.searchProductResponse)

  // @@protoc_insertion_point(class_scope:.service.message.merchant.searchProductResponse)

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
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "pages",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\Pagination',
      )));
      $desc->addField(3, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "category",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\CategoryNode',
      )));
      $desc->addField(4, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "words",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(5, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "wholesaler_list",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\Store',
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.merchant.searchProductResponse)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}