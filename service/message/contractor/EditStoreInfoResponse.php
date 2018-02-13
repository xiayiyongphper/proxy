<?php
namespace service\message\contractor;

// @@protoc_insertion_point(namespace:.service.message.contractor.EditStoreInfoResponse)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: contractor/EditStoreInfoResponse.proto
 *
 * -*- magic methods -*-
 *
 * @method \service\message\customer\CustomerResponse getStore()
 * @method void setStore(\service\message\customer\CustomerResponse $value)
 * @method array getAreas()
 * @method void appendAreas(\service\message\common\KeyValueItem $value)
 * @method array getTypes()
 * @method void appendTypes(\service\message\common\KeyValueItem $value)
 * @method array getLevels()
 * @method void appendLevels(\service\message\common\KeyValueItem $value)
 * @method array getOperations()
 * @method void appendOperations(\service\message\common\KeyValueItem $value)
 */
class EditStoreInfoResponse extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.contractor.EditStoreInfoResponse)
  
  /**
   * @var \service\message\customer\CustomerResponse $store
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   **/
  protected $store;
  
  /**
   * @var array $areas
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\KeyValueItem
   **/
  protected $areas;
  
  /**
   * @var array $types
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\KeyValueItem
   **/
  protected $types;
  
  /**
   * @var array $levels
   * @tag 4
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\KeyValueItem
   **/
  protected $levels;
  
  /**
   * @var array $operations
   * @tag 5
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\KeyValueItem
   **/
  protected $operations;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.contractor.EditStoreInfoResponse)

  // @@protoc_insertion_point(class_scope:.service.message.contractor.EditStoreInfoResponse)

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
        "name"     => "store",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\customer\CustomerResponse',
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "areas",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\KeyValueItem',
      )));
      $desc->addField(3, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "types",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\KeyValueItem',
      )));
      $desc->addField(4, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "levels",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\KeyValueItem',
      )));
      $desc->addField(5, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "operations",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\KeyValueItem',
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.contractor.EditStoreInfoResponse)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}