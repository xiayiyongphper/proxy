<?php
namespace service\message\contractor;

// @@protoc_insertion_point(namespace:.service.message.contractor.QuickRegisterCustomerRequest)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: contractor/QuickRegisterCustomerRequest.proto
 *
 * -*- magic methods -*-
 *
 * @method string getContractorId()
 * @method void setContractorId(\string $value)
 * @method string getAuthToken()
 * @method void setAuthToken(\string $value)
 * @method string getPhone()
 * @method void setPhone(\string $value)
 * @method string getCode()
 * @method void setCode(\string $value)
 * @method string getCustomerId()
 * @method void setCustomerId(\string $value)
 * @method string getUsername()
 * @method void setUsername(\string $value)
 * @method string getPassword()
 * @method void setPassword(\string $value)
 */
class QuickRegisterCustomerRequest extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.contractor.QuickRegisterCustomerRequest)
  
  /**
   * @var string $contractor_id
   * @tag 1
   * @label required
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $contractor_id;
  
  /**
   * @var string $auth_token
   * @tag 2
   * @label required
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $auth_token;
  
  /**
   * @var string $phone
   * @tag 3
   * @label required
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $phone;
  
  /**
   * @var string $code
   * @tag 4
   * @label required
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $code;
  
  /**
   * @var string $customer_id
   * @tag 5
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $customer_id;
  
  /**
   * @var string $username
   * @tag 6
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $username;
  
  /**
   * @var string $password
   * @tag 7
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $password;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.contractor.QuickRegisterCustomerRequest)

  // @@protoc_insertion_point(class_scope:.service.message.contractor.QuickRegisterCustomerRequest)

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
        "name"     => "contractor_id",
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
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "phone",
        "required" => true,
        "optional" => false,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(4, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "code",
        "required" => true,
        "optional" => false,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(5, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "customer_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(6, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "username",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(7, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "password",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.contractor.QuickRegisterCustomerRequest)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}