<?php
namespace service\message\contractor;

// @@protoc_insertion_point(namespace:.service.message.contractor.GetStoreInfoResponse)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: contractor/GetStoreInfoResponse.proto
 *
 * -*- magic methods -*-
 *
 * @method \service\message\customer\CustomerResponse getStore()
 * @method void setStore(\service\message\customer\CustomerResponse $value)
 * @method string getRecordsCount()
 * @method void setRecordsCount(\string $value)
 * @method \service\message\contractor\VisitRecord getFinalRecord()
 * @method void setFinalRecord(\service\message\contractor\VisitRecord $value)
 * @method array getOrderInfo()
 * @method void appendOrderInfo(\service\message\common\KeyValueItem $value)
 */
class GetStoreInfoResponse extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.contractor.GetStoreInfoResponse)
  
  /**
   * @var \service\message\customer\CustomerResponse $store
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   **/
  protected $store;
  
  /**
   * @var string $records_count
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $records_count;
  
  /**
   * @var \service\message\contractor\VisitRecord $final_record
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   **/
  protected $final_record;
  
  /**
   * @var array $order_info
   * @tag 4
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\KeyValueItem
   **/
  protected $order_info;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.contractor.GetStoreInfoResponse)

  // @@protoc_insertion_point(class_scope:.service.message.contractor.GetStoreInfoResponse)

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
        "name"     => "store",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\customer\CustomerResponse',
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "records_count",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(3, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "final_record",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\contractor\VisitRecord',
      )));
      $desc->addField(4, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "order_info",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\KeyValueItem',
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.contractor.GetStoreInfoResponse)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}