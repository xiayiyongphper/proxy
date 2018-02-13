<?php
namespace service\message\customer;

// @@protoc_insertion_point(namespace:.service.message.customer.ConfirmVerifyCodeRequest)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: customer/ConfirmVerifyCodeRequest.proto
 *
 * -*- magic methods -*-
 *
 * @method string getType()
 * @method void setType(\string $value)
 * @method string getPhone()
 * @method void setPhone(\string $value)
 * @method string getCode()
 * @method void setCode(\string $value)
 */
class ConfirmVerifyCodeRequest extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.customer.ConfirmVerifyCodeRequest)
  
  /**
   * @var string $type
   * @tag 1
   * @label required
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $type;
  
  /**
   * @var string $phone
   * @tag 2
   * @label required
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $phone;
  
  /**
   * @var string $code
   * @tag 3
   * @label required
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $code;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.customer.ConfirmVerifyCodeRequest)

  // @@protoc_insertion_point(class_scope:.service.message.customer.ConfirmVerifyCodeRequest)

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
        "name"     => "type",
        "required" => true,
        "optional" => false,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "phone",
        "required" => true,
        "optional" => false,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(3, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "code",
        "required" => true,
        "optional" => false,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.customer.ConfirmVerifyCodeRequest)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}