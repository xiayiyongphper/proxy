<?php
namespace service\message\sync;

// @@protoc_insertion_point(namespace:.service.message.sync.Job)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: sync/Job.proto
 *
 * -*- magic methods -*-
 *
 * @method array getAction()
 * @method void appendAction(\service\message\sync\Action $value)
 * @method string getTimestamp()
 * @method void setTimestamp(\string $value)
 * @method string getVersion()
 * @method void setVersion(\string $value)
 * @method string getCustomerId()
 * @method void setCustomerId(\string $value)
 * @method string getAuthToken()
 * @method void setAuthToken(\string $value)
 * @method string getTaskNo()
 * @method void setTaskNo(\string $value)
 */
class Job extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.sync.Job)
  
  /**
   * @var array $action
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\sync\Action
   **/
  protected $action;
  
  /**
   * @var string $timestamp
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $timestamp;
  
  /**
   * @var string $version
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $version;
  
  /**
   * @var string $customer_id
   * @tag 4
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $customer_id;
  
  /**
   * @var string $auth_token
   * @tag 5
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $auth_token;
  
  /**
   * @var string $task_no
   * @tag 6
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $task_no;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.sync.Job)

  // @@protoc_insertion_point(class_scope:.service.message.sync.Job)

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
        "name"     => "action",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\sync\Action',
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "timestamp",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
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
      $desc->addField(4, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "customer_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(5, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "auth_token",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(6, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "task_no",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.sync.Job)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
