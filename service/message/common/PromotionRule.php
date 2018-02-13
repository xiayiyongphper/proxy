<?php
namespace service\message\common;

// @@protoc_insertion_point(namespace:.service.message.common.PromotionRule)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: common/PromotionRule.proto
 *
 * -*- magic methods -*-
 *
 * @method string getPromotionType()
 * @method void setPromotionType(\string $value)
 * @method array getRule()
 * @method void appendRule(\service\message\common\Rule $value)
 * @method string getRuleId()
 * @method void setRuleId(\string $value)
 * @method string getName()
 * @method void setName(\string $value)
 * @method string getType()
 * @method void setType(\string $value)
 * @method string getTopicDescription()
 * @method void setTopicDescription(\string $value)
 * @method string getTopicBanner()
 * @method void setTopicBanner(\string $value)
 * @method string getTagShort()
 * @method void setTagShort(\string $value)
 * @method string getTagShortColor()
 * @method void setTagShortColor(\string $value)
 * @method string getTagLong()
 * @method void setTagLong(\string $value)
 * @method string getTagLongColor()
 * @method void setTagLongColor(\string $value)
 * @method string getWholesalerId()
 * @method void setWholesalerId(\string $value)
 * @method string getWholesalerDescription()
 * @method void setWholesalerDescription(\string $value)
 * @method string getTagIcon()
 * @method void setTagIcon(\string $value)
 * @method string getTagUrl()
 * @method void setTagUrl(\string $value)
 * @method string getStopRulesProcessing()
 * @method void setStopRulesProcessing(\string $value)
 * @method string getCouponType()
 * @method void setCouponType(\string $value)
 */
class PromotionRule extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.common.PromotionRule)
  
  /**
   * @var string $promotion_type
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   *
   * 1.满额减;2.满额折;3.满额赠;4.满量减;5.满量折;6.满量赠
   *
   **/
  protected $promotion_type;
  
  /**
   * @var array $rule
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\Rule
   *
   * 解析后的规则
   *
   **/
  protected $rule;
  
  /**
   * @var string $rule_id
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $rule_id;
  
  /**
   * @var string $name
   * @tag 4
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $name;
  
  /**
   * @var string $type
   * @tag 5
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   *
   * 优惠级别，1.单品级,2.多品级,3.订单级
   *
   **/
  protected $type;
  
  /**
   * @var string $topic_description
   * @tag 6
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $topic_description;
  
  /**
   * @var string $topic_banner
   * @tag 7
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $topic_banner;
  
  /**
   * @var string $tag_short
   * @tag 8
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $tag_short;
  
  /**
   * @var string $tag_short_color
   * @tag 9
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $tag_short_color;
  
  /**
   * @var string $tag_long
   * @tag 10
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $tag_long;
  
  /**
   * @var string $tag_long_color
   * @tag 11
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $tag_long_color;
  
  /**
   * @var string $wholesaler_id
   * @tag 12
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   *
   * 使用店铺ID查出来的规则
   *
   **/
  protected $wholesaler_id;
  
  /**
   * @var string $wholesaler_description
   * @tag 13
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   *
   * 店铺优惠规则说明
   *
   **/
  protected $wholesaler_description;
  
  /**
   * @var string $tag_icon
   * @tag 14
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   *
   * tag图标
   *
   **/
  protected $tag_icon;
  
  /**
   * @var string $tag_url
   * @tag 15
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   *
   * tag URL
   *
   **/
  protected $tag_url;
  
  /**
   * @var string $stop_rules_processing
   * @tag 16
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   *
   * 是否参加计算订单级优惠 0：不停止  1停止
   *
   **/
  protected $stop_rules_processing;
  
  /**
   * @var string $coupon_type
   * @tag 17
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   *
   * 1、无优惠券   2以后是有优惠券
   *
   **/
  protected $coupon_type;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.common.PromotionRule)

  // @@protoc_insertion_point(class_scope:.service.message.common.PromotionRule)

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
        "name"     => "promotion_type",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "rule",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\Rule',
      )));
      $desc->addField(3, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "rule_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(4, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "name",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(5, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "type",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(6, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "topic_description",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(7, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "topic_banner",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(8, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "tag_short",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(9, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "tag_short_color",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(10, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "tag_long",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(11, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "tag_long_color",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(12, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "wholesaler_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(13, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "wholesaler_description",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(14, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "tag_icon",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(15, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "tag_url",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(16, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "stop_rules_processing",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(17, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "coupon_type",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.common.PromotionRule)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}