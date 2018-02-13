<?php
namespace service\message\common;

// @@protoc_insertion_point(namespace:.service.message.common.KeyValueItem)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: common/KeyValueItem.proto
 *
 * -*- magic methods -*-
 *
 * @method string getKey()
 * @method void setKey(\string $value)
 * @method string getValue()
 * @method void setValue(\string $value)
 */
class KeyValueItem extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.common.KeyValueItem)
  
  /**
   * @var string $key
   * @tag 1
   * @label required
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $key;
  
  /**
   * @var string $value
   * @tag 2
   * @label required
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $value;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.common.KeyValueItem)

  // @@protoc_insertion_point(class_scope:.service.message.common.KeyValueItem)

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
        "name"     => "key",
        "required" => true,
        "optional" => false,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "value",
        "required" => true,
        "optional" => false,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.common.KeyValueItem)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}