<?php
namespace service\message\common;

// @@protoc_insertion_point(namespace:.service.message.common.ResponseHeader)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: common/ResponseHeader.proto
 *
 * -*- magic methods -*-
 *
 * @method string getCode()
 * @method void setCode(\string $value)
 * @method string getMsg()
 * @method void setMsg(\string $value)
 * @method string getTimestamp()
 * @method void setTimestamp(\string $value)
 * @method string getRoute()
 * @method void setRoute(\string $value)
 * @method string getRequestId()
 * @method void setRequestId(\string $value)
 * @method \service\message\common\ContentType getContentType()
 * @method void setContentType(\service\message\common\ContentType $value)
 * @method string getChecksum()
 * @method void setChecksum(\string $value)
 * @method string getFilename()
 * @method void setFilename(\string $value)
 */
class ResponseHeader extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.common.ResponseHeader)
  
  /**
   * @var string $code
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $code;
  
  /**
   * @var string $msg
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $msg;
  
  /**
   * @var string $timestamp
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $timestamp;
  
  /**
   * @var string $route
   * @tag 4
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $route;
  
  /**
   * @var string $request_id
   * @tag 5
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $request_id;
  
  /**
   * @var \service\message\common\ContentType $content_type
   * @tag 6
   * @label optional
   * @type \ProtocolBuffers::TYPE_ENUM
   * @see \service\message\common\ContentType
   **/
  protected $content_type;
  
  /**
   * @var string $checksum
   * @tag 7
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $checksum;
  
  /**
   * @var string $filename
   * @tag 8
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $filename;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.common.ResponseHeader)

  // @@protoc_insertion_point(class_scope:.service.message.common.ResponseHeader)

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
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "msg",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(3, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "timestamp",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(4, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "route",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(5, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "request_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(6, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_ENUM,
        "name"     => "content_type",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => \service\message\common\ContentType::APPLICATION_PB_STREAM,
      )));
      $desc->addField(7, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "checksum",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(8, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "filename",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.common.ResponseHeader)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}