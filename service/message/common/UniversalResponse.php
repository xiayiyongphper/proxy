<?php
namespace service\message\common;

// @@protoc_insertion_point(namespace:.service.message.common.UniversalResponse)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: common/UniversalResponse.proto
 *
 * -*- magic methods -*-
 *
 * @method string getCode()
 * @method void setCode(\string $value)
 * @method string getMessage()
 * @method void setMessage(\string $value)
 */
class UniversalResponse extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.common.UniversalResponse)
  
  /**
   * @var string $code
   * @tag 1
   * @label required
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $code;
  
  /**
   * @var string $message
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $message;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.common.UniversalResponse)

  // @@protoc_insertion_point(class_scope:.service.message.common.UniversalResponse)

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
        "name"     => "code",
        "required" => true,
        "optional" => false,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "message",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.common.UniversalResponse)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
