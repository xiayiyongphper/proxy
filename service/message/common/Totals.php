<?php
namespace service\message\common;

// @@protoc_insertion_point(namespace:.service.message.common.Totals)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: common/Totals.proto
 *
 * -*- magic methods -*-
 *
 * @method string getBaseTotal()
 * @method void setBaseTotal(\string $value)
 * @method string getShippingAmount()
 * @method void setShippingAmount(\string $value)
 * @method string getDiscountAmount()
 * @method void setDiscountAmount(\string $value)
 * @method string getCouponDiscountAmount()
 * @method void setCouponDiscountAmount(\string $value)
 * @method string getGrandTotal()
 * @method void setGrandTotal(\string $value)
 * @method string getBalance()
 * @method void setBalance(\string $value)
 * @method string getTotalQty()
 * @method void setTotalQty(\string $value)
 * @method string getReceiptTotal()
 * @method void setReceiptTotal(\string $value)
 */
class Totals extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.common.Totals)
  
  /**
   * @var string $base_total
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_FLOAT
   **/
  protected $base_total;
  
  /**
   * @var string $shipping_amount
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_FLOAT
   **/
  protected $shipping_amount;
  
  /**
   * @var string $discount_amount
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_FLOAT
   **/
  protected $discount_amount;
  
  /**
   * @var string $coupon_discount_amount
   * @tag 4
   * @label optional
   * @type \ProtocolBuffers::TYPE_FLOAT
   **/
  protected $coupon_discount_amount;
  
  /**
   * @var string $grand_total
   * @tag 5
   * @label optional
   * @type \ProtocolBuffers::TYPE_FLOAT
   **/
  protected $grand_total;
  
  /**
   * @var string $balance
   * @tag 6
   * @label optional
   * @type \ProtocolBuffers::TYPE_FLOAT
   **/
  protected $balance;
  
  /**
   * @var string $total_qty
   * @tag 7
   * @label optional
   * @type \ProtocolBuffers::TYPE_FLOAT
   **/
  protected $total_qty;
  
  /**
   * @var string $receipt_total
   * @tag 8
   * @label optional
   * @type \ProtocolBuffers::TYPE_FLOAT
   **/
  protected $receipt_total;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.common.Totals)

  // @@protoc_insertion_point(class_scope:.service.message.common.Totals)

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
        "type"     => \ProtocolBuffers::TYPE_FLOAT,
        "name"     => "base_total",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_FLOAT,
        "name"     => "shipping_amount",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(3, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_FLOAT,
        "name"     => "discount_amount",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(4, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_FLOAT,
        "name"     => "coupon_discount_amount",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(5, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_FLOAT,
        "name"     => "grand_total",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(6, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_FLOAT,
        "name"     => "balance",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(7, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_FLOAT,
        "name"     => "total_qty",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(8, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_FLOAT,
        "name"     => "receipt_total",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.common.Totals)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}