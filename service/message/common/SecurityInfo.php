<?php
namespace service\message\common;

// @@protoc_insertion_point(namespace:.service.message.common.SecurityInfo)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: common/SecurityInfo.proto
 *
 * -*- magic methods -*-
 *
 * @method string getIcon()
 * @method void setIcon(\string $value)
 * @method string getText()
 * @method void setText(\string $value)
 */
class SecurityInfo extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.common.SecurityInfo)
  
  /**
   * @var string $icon
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $icon;
  
  /**
   * @var string $text
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $text;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.common.SecurityInfo)

  // @@protoc_insertion_point(class_scope:.service.message.common.SecurityInfo)

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
        "name"     => "icon",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "text",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.common.SecurityInfo)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}