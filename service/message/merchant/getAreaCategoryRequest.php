<?php
namespace service\message\merchant;

// @@protoc_insertion_point(namespace:.service.message.merchant.getAreaCategoryRequest)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: merchant/getAreaCategoryRequest.proto
 *
 * -*- magic methods -*-
 *
 * @method string getCustomerId()
 * @method void setCustomerId(\string $value)
 * @method string getAuthToken()
 * @method void setAuthToken(\string $value)
 * @method string getWholesalerId()
 * @method void setWholesalerId(\string $value)
 */
class getAreaCategoryRequest extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.merchant.getAreaCategoryRequest)
  
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
   * @var string $wholesaler_id
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $wholesaler_id;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.merchant.getAreaCategoryRequest)

  // @@protoc_insertion_point(class_scope:.service.message.merchant.getAreaCategoryRequest)

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
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "wholesaler_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.merchant.getAreaCategoryRequest)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
