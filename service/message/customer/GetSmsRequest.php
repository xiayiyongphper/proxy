<?php
namespace service\message\customer;

// @@protoc_insertion_point(namespace:.service.message.customer.GetSmsRequest)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: customer/GetSmsRequest.proto
 *
 * -*- magic methods -*-
 *
 * @method string getType()
 * @method void setType(\string $value)
 * @method string getPhone()
 * @method void setPhone(\string $value)
 * @method string getToken()
 * @method void setToken(\string $value)
 */
class GetSmsRequest extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.customer.GetSmsRequest)
  
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
   * @var string $token
   * @tag 3
   * @label required
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $token;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.customer.GetSmsRequest)

  // @@protoc_insertion_point(class_scope:.service.message.customer.GetSmsRequest)

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
        "name"     => "token",
        "required" => true,
        "optional" => false,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.customer.GetSmsRequest)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
