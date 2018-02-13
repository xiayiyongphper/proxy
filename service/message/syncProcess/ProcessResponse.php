<?php
namespace service\message\syncProcess;

// @@protoc_insertion_point(namespace:.service.message.syncProcess.ProcessResponse)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: syncProcess/ProcessResponse.proto
 *
 * -*- magic methods -*-
 *
 * @method string getCode()
 * @method void setCode(\string $value)
 * @method string getMessage()
 * @method void setMessage(\string $value)
 * @method string getCustomerId()
 * @method void setCustomerId(\string $value)
 * @method string getTaskNo()
 * @method void setTaskNo(\string $value)
 * @method \service\message\syncProcess\Status getStatus()
 * @method void setStatus(\service\message\syncProcess\Status $value)
 * @method string getVersion()
 * @method void setVersion(\string $value)
 */
class ProcessResponse extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.syncProcess.ProcessResponse)
  
  /**
   * @var string $code
   * @tag 1
   * @label optional
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
  
  /**
   * @var string $customer_id
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $customer_id;
  
  /**
   * @var string $task_no
   * @tag 4
   * @label required
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $task_no;
  
  /**
   * @var \service\message\syncProcess\Status $status
   * @tag 5
   * @label required
   * @type \ProtocolBuffers::TYPE_ENUM
   * @see \service\message\syncProcess\Status
   **/
  protected $status;
  
  /**
   * @var string $version
   * @tag 6
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $version;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.syncProcess.ProcessResponse)

  // @@protoc_insertion_point(class_scope:.service.message.syncProcess.ProcessResponse)

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
        "name"     => "message",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(3, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "customer_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(4, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "task_no",
        "required" => true,
        "optional" => false,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(5, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_ENUM,
        "name"     => "status",
        "required" => true,
        "optional" => false,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(6, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "version",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.syncProcess.ProcessResponse)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}