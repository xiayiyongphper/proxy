<?php
namespace service\message\contractor;

// @@protoc_insertion_point(namespace:.service.message.contractor.visitedRecordsRequest)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: contractor/visitedRecordsRequest.proto
 *
 * -*- magic methods -*-
 *
 * @method string getContractorId()
 * @method void setContractorId(\string $value)
 * @method string getAuthToken()
 * @method void setAuthToken(\string $value)
 * @method string getCustomerId()
 * @method void setCustomerId(\string $value)
 * @method \service\message\common\Pagination getPagination()
 * @method void setPagination(\service\message\common\Pagination $value)
 */
class visitedRecordsRequest extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.contractor.visitedRecordsRequest)
  
  /**
   * @var string $contractor_id
   * @tag 1
   * @label required
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $contractor_id;
  
  /**
   * @var string $auth_token
   * @tag 2
   * @label required
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $auth_token;
  
  /**
   * @var string $customer_id
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $customer_id;
  
  /**
   * @var \service\message\common\Pagination $pagination
   * @tag 4
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   **/
  protected $pagination;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.contractor.visitedRecordsRequest)

  // @@protoc_insertion_point(class_scope:.service.message.contractor.visitedRecordsRequest)

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
        "name"     => "contractor_id",
        "required" => true,
        "optional" => false,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "auth_token",
        "required" => true,
        "optional" => false,
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
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "pagination",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\Pagination',
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.contractor.visitedRecordsRequest)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
