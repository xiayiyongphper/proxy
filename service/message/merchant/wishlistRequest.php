<?php
namespace service\message\merchant;

// @@protoc_insertion_point(namespace:.service.message.merchant.wishlistRequest)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: merchant/wishlistRequest.proto
 *
 * -*- magic methods -*-
 *
 * @method string getCustomerId()
 * @method void setCustomerId(\string $value)
 * @method string getAuthToken()
 * @method void setAuthToken(\string $value)
 * @method array getProducts()
 * @method void appendProducts(\service\message\common\Product $value)
 * @method \service\message\common\Pagination getPagination()
 * @method void setPagination(\service\message\common\Pagination $value)
 */
class wishlistRequest extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.merchant.wishlistRequest)
  
  /**
   * @var string $customer_id
   * @tag 1
   * @label required
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $customer_id;
  
  /**
   * @var string $auth_token
   * @tag 2
   * @label required
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $auth_token;
  
  /**
   * @var array $products
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\Product
   **/
  protected $products;
  
  /**
   * @var \service\message\common\Pagination $pagination
   * @tag 4
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   **/
  protected $pagination;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.merchant.wishlistRequest)

  // @@protoc_insertion_point(class_scope:.service.message.merchant.wishlistRequest)

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
        "name"     => "customer_id",
        "required" => true,
        "optional" => false,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "auth_token",
        "required" => true,
        "optional" => false,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(3, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "products",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\Product',
      )));
      $desc->addField(4, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "pagination",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\Pagination',
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.merchant.wishlistRequest)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
