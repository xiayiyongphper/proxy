<?php
namespace service\message\customer;

// @@protoc_insertion_point(namespace:.service.message.customer.LoginRequest)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: customer/LoginRequest.proto
 *
 * -*- magic methods -*-
 *
 * @method string getUsername()
 * @method void setUsername(\string $value)
 * @method string getPassword()
 * @method void setPassword(\string $value)
 */
class LoginRequest extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.customer.LoginRequest)
  
  /**
   * @var string $username
   * @tag 1
   * @label required
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $username;
  
  /**
   * @var string $password
   * @tag 2
   * @label required
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $password;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.customer.LoginRequest)

  // @@protoc_insertion_point(class_scope:.service.message.customer.LoginRequest)

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
        "name"     => "username",
        "required" => true,
        "optional" => false,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "password",
        "required" => true,
        "optional" => false,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.customer.LoginRequest)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
