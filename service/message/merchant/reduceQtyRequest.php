<?php
namespace service\message\merchant;

// @@protoc_insertion_point(namespace:.service.message.merchant.reduceQtyRequest)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: merchant/reduceQtyRequest.proto
 *
 * -*- magic methods -*-
 *
 * @method string getCustomerId()
 * @method void setCustomerId(\string $value)
 * @method string getAuthToken()
 * @method void setAuthToken(\string $value)
 * @method array getProducts()
 * @method void appendProducts(\service\message\common\Product $value)
 */
class reduceQtyRequest extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.merchant.reduceQtyRequest)
  
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
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.merchant.reduceQtyRequest)

  // @@protoc_insertion_point(class_scope:.service.message.merchant.reduceQtyRequest)

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
      // @@protoc_insertion_point(builder_scope:.service.message.merchant.reduceQtyRequest)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
