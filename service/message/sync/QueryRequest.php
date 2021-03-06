<?php
namespace service\message\sync;

// @@protoc_insertion_point(namespace:.service.message.sync.QueryRequest)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: sync/QueryRequest.proto
 *
 * -*- magic methods -*-
 *
 * @method string getTaskNo()
 * @method void setTaskNo(\string $value)
 * @method string getCustomerId()
 * @method void setCustomerId(\string $value)
 * @method string getAuthToken()
 * @method void setAuthToken(\string $value)
 */
class QueryRequest extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.sync.QueryRequest)
  
  /**
   * @var string $task_no
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $task_no;
  
  /**
   * @var string $customer_id
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $customer_id;
  
  /**
   * @var string $auth_token
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $auth_token;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.sync.QueryRequest)

  // @@protoc_insertion_point(class_scope:.service.message.sync.QueryRequest)

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
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "customer_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(3, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "auth_token",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.sync.QueryRequest)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
