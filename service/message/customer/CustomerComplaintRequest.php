<?php
namespace service\message\customer;

// @@protoc_insertion_point(namespace:.service.message.customer.CustomerComplaintRequest)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: customer/CustomerComplaintRequest.proto
 *
 * -*- magic methods -*-
 *
 * @method string getCustomerId()
 * @method void setCustomerId(\string $value)
 * @method string getAuthToken()
 * @method void setAuthToken(\string $value)
 * @method string getWholesalerId()
 * @method void setWholesalerId(\string $value)
 * @method string getIncrementId()
 * @method void setIncrementId(\string $value)
 * @method string getContactName()
 * @method void setContactName(\string $value)
 * @method string getContactPhone()
 * @method void setContactPhone(\string $value)
 * @method string getContent()
 * @method void setContent(\string $value)
 * @method string getType()
 * @method void setType(\string $value)
 */
class CustomerComplaintRequest extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.customer.CustomerComplaintRequest)
  
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
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $wholesaler_id;
  
  /**
   * @var string $increment_id
   * @tag 4
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $increment_id;
  
  /**
   * @var string $contact_name
   * @tag 5
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $contact_name;
  
  /**
   * @var string $contact_phone
   * @tag 6
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $contact_phone;
  
  /**
   * @var string $content
   * @tag 7
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $content;
  
  /**
   * @var string $type
   * @tag 8
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $type;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.customer.CustomerComplaintRequest)

  // @@protoc_insertion_point(class_scope:.service.message.customer.CustomerComplaintRequest)

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
        "name"     => "wholesaler_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(4, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "increment_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(5, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "contact_name",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(6, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "contact_phone",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
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
      $desc->addField(8, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "type",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.customer.CustomerComplaintRequest)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
