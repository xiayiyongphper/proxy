<?php
namespace service\message\sync;

// @@protoc_insertion_point(namespace:.service.message.sync.AuthorizeResponse)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: sync/AuthorizeResponse.proto
 *
 * -*- magic methods -*-
 *
 * @method string getAccessToken()
 * @method void setAccessToken(\string $value)
 * @method string getExpires()
 * @method void setExpires(\string $value)
 */
class AuthorizeResponse extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.sync.AuthorizeResponse)
  
  /**
   * @var string $access_token
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $access_token;
  
  /**
   * @var string $expires
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $expires;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.sync.AuthorizeResponse)

  // @@protoc_insertion_point(class_scope:.service.message.sync.AuthorizeResponse)

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
        "name"     => "access_token",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "expires",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.sync.AuthorizeResponse)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
