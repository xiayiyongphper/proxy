<?php
namespace service\message\contractor;

// @@protoc_insertion_point(namespace:.service.message.contractor.StoresResponse)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: contractor/StoresResponse.proto
 *
 * -*- magic methods -*-
 *
 * @method array getStores()
 * @method void appendStores(\service\message\customer\CustomerResponse $value)
 * @method \service\message\common\Pagination getPagination()
 * @method void setPagination(\service\message\common\Pagination $value)
 */
class StoresResponse extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.contractor.StoresResponse)
  
  /**
   * @var array $stores
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\customer\CustomerResponse
   **/
  protected $stores;
  
  /**
   * @var \service\message\common\Pagination $pagination
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   **/
  protected $pagination;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.contractor.StoresResponse)

  // @@protoc_insertion_point(class_scope:.service.message.contractor.StoresResponse)

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
        "name"     => "stores",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\customer\CustomerResponse',
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "pagination",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\Pagination',
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.contractor.StoresResponse)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
