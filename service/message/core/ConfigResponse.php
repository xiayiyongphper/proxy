<?php
namespace service\message\core;

// @@protoc_insertion_point(namespace:.service.message.core.ConfigResponse)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: core/ConfigResponse.proto
 *
 * -*- magic methods -*-
 *
 * @method string getCsh()
 * @method void setCsh(\string $value)
 * @method string getAdShowTime()
 * @method void setAdShowTime(\string $value)
 * @method string getHelperUrl()
 * @method void setHelperUrl(\string $value)
 * @method string getVer()
 * @method void setVer(\string $value)
 * @method bool getDebug()
 * @method void setDebug(bool $value)
 * @method array getDebugOptions()
 * @method void appendDebugOptions(\service\message\common\KeyValueItem $value)
 * @method string getWalletHelperUrl()
 * @method void setWalletHelperUrl(\string $value)
 * @method string getJsCart()
 * @method void setJsCart(\string $value)
 * @method string getCouponHelperUrl()
 * @method void setCouponHelperUrl(\string $value)
 */
class ConfigResponse extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.core.ConfigResponse)
  
  /**
   * @var string $csh
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $csh;
  
  /**
   * @var string $ad_show_time
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $ad_show_time;
  
  /**
   * @var string $helper_url
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $helper_url;
  
  /**
   * @var string $ver
   * @tag 4
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $ver;
  
  /**
   * @var bool $debug
   * @tag 5
   * @label optional
   * @type \ProtocolBuffers::TYPE_BOOL
   **/
  protected $debug;
  
  /**
   * @var array $debug_options
   * @tag 6
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\KeyValueItem
   **/
  protected $debug_options;
  
  /**
   * @var string $wallet_helper_url
   * @tag 7
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $wallet_helper_url;
  
  /**
   * @var string $js_cart
   * @tag 8
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $js_cart;
  
  /**
   * @var string $coupon_helper_url
   * @tag 9
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $coupon_helper_url;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.core.ConfigResponse)

  // @@protoc_insertion_point(class_scope:.service.message.core.ConfigResponse)

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
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "csh",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "ad_show_time",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(3, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "helper_url",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(4, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "ver",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(5, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_BOOL,
        "name"     => "debug",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => false,
      )));
      $desc->addField(6, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "debug_options",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\KeyValueItem',
      )));
      $desc->addField(7, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "wallet_helper_url",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(8, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "js_cart",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(9, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "coupon_helper_url",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.core.ConfigResponse)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
