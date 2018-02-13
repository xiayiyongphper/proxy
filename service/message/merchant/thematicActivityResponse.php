<?php
namespace service\message\merchant;

// @@protoc_insertion_point(namespace:.service.message.merchant.thematicActivityResponse)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: merchant/thematicActivityResponse.proto
 *
 * -*- magic methods -*-
 *
 * @method array getBanner()
 * @method void appendBanner(\service\message\common\Image $value)
 * @method string getRule()
 * @method void setRule(\string $value)
 * @method array getThematic()
 * @method void appendThematic(\service\message\common\Thematic $value)
 * @method string getTitle()
 * @method void setTitle(\string $value)
 * @method \service\message\common\CouponReceiveLayout getCouponReceiveLayout()
 * @method void setCouponReceiveLayout(\service\message\common\CouponReceiveLayout $value)
 */
class thematicActivityResponse extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.merchant.thematicActivityResponse)
  
  /**
   * @var array $banner
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\Image
   **/
  protected $banner;
  
  /**
   * @var string $rule
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $rule;
  
  /**
   * @var array $thematic
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\Thematic
   **/
  protected $thematic;
  
  /**
   * @var string $title
   * @tag 4
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $title;
  
  /**
   * @var \service\message\common\CouponReceiveLayout $coupon_receive_layout
   * @tag 5
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   **/
  protected $coupon_receive_layout;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.merchant.thematicActivityResponse)

  // @@protoc_insertion_point(class_scope:.service.message.merchant.thematicActivityResponse)

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
        "name"     => "banner",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\Image',
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "rule",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(3, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "thematic",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\Thematic',
      )));
      $desc->addField(4, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "title",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(5, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "coupon_receive_layout",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\CouponReceiveLayout',
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.merchant.thematicActivityResponse)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
