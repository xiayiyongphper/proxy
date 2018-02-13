<?php
namespace service\message\customer;

// @@protoc_insertion_point(namespace:.service.message.customer.FeedbackRequest)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: customer/FeedbackRequest.proto
 *
 * -*- magic methods -*-
 *
 * @method string getCustomerId()
 * @method void setCustomerId(\string $value)
 * @method string getAuthToken()
 * @method void setAuthToken(\string $value)
 * @method string getUserName()
 * @method void setUserName(\string $value)
 * @method string getPhone()
 * @method void setPhone(\string $value)
 * @method string getTypevar()
 * @method void setTypevar(\string $value)
 * @method string getTypeId()
 * @method void setTypeId(\string $value)
 * @method string getContent()
 * @method void setContent(\string $value)
 */
class FeedbackRequest extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.customer.FeedbackRequest)
  
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
   * @var string $user_name
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $user_name;
  
  /**
   * @var string $phone
   * @tag 4
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $phone;
  
  /**
   * @var string $typevar
   * @tag 5
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $typevar;
  
  /**
   * @var string $type_id
   * @tag 6
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $type_id;
  
  /**
   * @var string $content
   * @tag 7
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $content;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.customer.FeedbackRequest)

  // @@protoc_insertion_point(class_scope:.service.message.customer.FeedbackRequest)

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
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "user_name",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(4, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "phone",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(5, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "typevar",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(6, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "type_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(7, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "content",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.customer.FeedbackRequest)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
