<?php
namespace service\message\sync;

// @@protoc_insertion_point(namespace:.service.message.sync.QueryResponse)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: sync/QueryResponse.proto
 *
 * -*- magic methods -*-
 *
 * @method string getTaskNo()
 * @method void setTaskNo(\string $value)
 * @method \service\message\syncProcess\Status getStatus()
 * @method void setStatus(\service\message\syncProcess\Status $value)
 * @method string getVersion()
 * @method void setVersion(\string $value)
 */
class QueryResponse extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.sync.QueryResponse)
  
  /**
   * @var string $task_no
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $task_no;
  
  /**
   * @var \service\message\syncProcess\Status $status
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_ENUM
   * @see \service\message\syncProcess\Status
   **/
  protected $status;
  
  /**
   * @var string $version
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $version;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.sync.QueryResponse)

  // @@protoc_insertion_point(class_scope:.service.message.sync.QueryResponse)

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
        "name"     => "task_no",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_ENUM,
        "name"     => "status",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(3, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "version",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.sync.QueryResponse)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
