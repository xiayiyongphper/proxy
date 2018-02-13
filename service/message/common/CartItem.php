<?php
namespace service\message\common;

// @@protoc_insertion_point(namespace:.service.message.common.CartItem)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: common/CartItem.proto
 *
 * -*- magic methods -*-
 *
 * @method string getMinTradeAmount()
 * @method void setMinTradeAmount(\string $value)
 * @method string getWholesalerId()
 * @method void setWholesalerId(\string $value)
 * @method string getWholesalerName()
 * @method void setWholesalerName(\string $value)
 * @method string getTips()
 * @method void setTips(\string $value)
 * @method array getList()
 * @method void appendList(\service\message\common\Product $value)
 * @method array getPromotions()
 * @method void appendPromotions(\service\message\common\PromotionInfo $value)
 */
class CartItem extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.common.CartItem)
  
  /**
   * @var string $min_trade_amount
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $min_trade_amount;
  
  /**
   * @var string $wholesaler_id
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $wholesaler_id;
  
  /**
   * @var string $wholesaler_name
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $wholesaler_name;
  
  /**
   * @var string $tips
   * @tag 4
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $tips;
  
  /**
   * @var array $list
   * @tag 5
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\Product
   **/
  protected $list;
  
  /**
   * @var array $promotions
   * @tag 6
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\PromotionInfo
   **/
  protected $promotions;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.common.CartItem)

  // @@protoc_insertion_point(class_scope:.service.message.common.CartItem)

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
        "name"     => "min_trade_amount",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "wholesaler_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(3, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "wholesaler_name",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(4, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "tips",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(5, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "list",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\Product',
      )));
      $desc->addField(6, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "promotions",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\PromotionInfo',
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.common.CartItem)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
