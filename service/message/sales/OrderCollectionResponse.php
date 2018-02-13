<?php
namespace service\message\sales;

// @@protoc_insertion_point(namespace:.service.message.sales.OrderCollectionResponse)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: sales/OrderCollectionResponse.proto
 *
 * -*- magic methods -*-
 *
 * @method array getItems()
 * @method void appendItems(\service\message\common\Order $value)
 * @method \service\message\common\Pagination getPagination()
 * @method void setPagination(\service\message\common\Pagination $value)
 */
class OrderCollectionResponse extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.sales.OrderCollectionResponse)
  
  /**
   * @var array $items
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\Order
   **/
  protected $items;
  
  /**
   * @var \service\message\common\Pagination $pagination
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   **/
  protected $pagination;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.sales.OrderCollectionResponse)

  // @@protoc_insertion_point(class_scope:.service.message.sales.OrderCollectionResponse)

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
        "name"     => "items",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\Order',
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
      // @@protoc_insertion_point(builder_scope:.service.message.sales.OrderCollectionResponse)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}