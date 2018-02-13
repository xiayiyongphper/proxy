<?php
namespace service\message\common;

// @@protoc_insertion_point(namespace:.service.message.common.Product)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: common/Product.proto
 *
 * -*- magic methods -*-
 *
 * @method string getProductId()
 * @method void setProductId(\string $value)
 * @method string getName()
 * @method void setName(\string $value)
 * @method string getUrl()
 * @method void setUrl(\string $value)
 * @method string getImage()
 * @method void setImage(\string $value)
 * @method string getPrice()
 * @method void setPrice(\string $value)
 * @method string getOriginalPrice()
 * @method void setOriginalPrice(\string $value)
 * @method string getDiscount()
 * @method void setDiscount(\string $value)
 * @method string getSold()
 * @method void setSold(\string $value)
 * @method string getQty()
 * @method void setQty(\string $value)
 * @method string getSpecification()
 * @method void setSpecification(\string $value)
 * @method string getWholesalerId()
 * @method void setWholesalerId(\string $value)
 * @method string getWholesalerName()
 * @method void setWholesalerName(\string $value)
 * @method string getWholesalerUrl()
 * @method void setWholesalerUrl(\string $value)
 * @method string getNum()
 * @method void setNum(\string $value)
 * @method string getBarcode()
 * @method void setBarcode(\string $value)
 * @method string getFirstCategoryId()
 * @method void setFirstCategoryId(\string $value)
 * @method string getSecondCategoryId()
 * @method void setSecondCategoryId(\string $value)
 * @method string getThirdCategoryId()
 * @method void setThirdCategoryId(\string $value)
 * @method string getSpecialPrice()
 * @method void setSpecialPrice(\string $value)
 * @method string getSpecialFromDate()
 * @method void setSpecialFromDate(\string $value)
 * @method string getSpecialToDate()
 * @method void setSpecialToDate(\string $value)
 * @method string getSoldQty()
 * @method void setSoldQty(\string $value)
 * @method string getRealSoldQty()
 * @method void setRealSoldQty(\string $value)
 * @method array getGallery()
 * @method void appendGallery(\string $value)
 * @method string getBrand()
 * @method void setBrand(\string $value)
 * @method string getExport()
 * @method void setExport(\string $value)
 * @method string getOrigin()
 * @method void setOrigin(\string $value)
 * @method string getPackageNum()
 * @method void setPackageNum(\string $value)
 * @method string getPackageSpe()
 * @method void setPackageSpe(\string $value)
 * @method string getPackage()
 * @method void setPackage(\string $value)
 * @method string getShelfLife()
 * @method void setShelfLife(\string $value)
 * @method string getDesc()
 * @method void setDesc(\string $value)
 * @method string getSortWeights()
 * @method void setSortWeights(\string $value)
 * @method string getShelfTime()
 * @method void setShelfTime(\string $value)
 * @method string getCreatedAt()
 * @method void setCreatedAt(\string $value)
 * @method string getUpdatedAt()
 * @method void setUpdatedAt(\string $value)
 * @method string getStatus()
 * @method void setStatus(\string $value)
 * @method string getState()
 * @method void setState(\string $value)
 * @method array getRecommendList()
 * @method void appendRecommendList(\service\message\common\Product $value)
 * @method array getParameters()
 * @method void appendParameters(\service\message\common\KeyValueItem $value)
 * @method string getPromotionTextFrom()
 * @method void setPromotionTextFrom(\string $value)
 * @method string getPromotionTextTo()
 * @method void setPromotionTextTo(\string $value)
 * @method string getPromotionText()
 * @method void setPromotionText(\string $value)
 * @method string getProductDescription()
 * @method void setProductDescription(\string $value)
 * @method string getMinimumOrder()
 * @method void setMinimumOrder(\string $value)
 * @method string getRebates()
 * @method void setRebates(\string $value)
 * @method string getRebatesLelai()
 * @method void setRebatesLelai(\string $value)
 * @method string getRebatesWholesaler()
 * @method void setRebatesWholesaler(\string $value)
 * @method string getRebatesAll()
 * @method void setRebatesAll(\string $value)
 * @method array getTags()
 * @method void appendTags(\service\message\common\Tag $value)
 * @method array getSecurityInfo()
 * @method void appendSecurityInfo(\service\message\common\SecurityInfo $value)
 * @method string getIsCalculateLelaiRebates()
 * @method void setIsCalculateLelaiRebates(\string $value)
 * @method string getCommission()
 * @method void setCommission(\string $value)
 * @method string getLelaiRebates()
 * @method void setLelaiRebates(\string $value)
 * @method bool getIsCollected()
 * @method void setIsCollected(bool $value)
 * @method string getRestrictDaily()
 * @method void setRestrictDaily(\string $value)
 * @method string getPurchasedQty()
 * @method void setPurchasedQty(\string $value)
 * @method string getSubsidiesWholesaler()
 * @method void setSubsidiesWholesaler(\string $value)
 * @method string getSubsidiesLelai()
 * @method void setSubsidiesLelai(\string $value)
 * @method string getFrequency()
 * @method void setFrequency(\string $value)
 * @method string getRuleId()
 * @method void setRuleId(\string $value)
 * @method \service\message\common\CouponReceiveLayout getCouponReceiveLayout()
 * @method void setCouponReceiveLayout(\service\message\common\CouponReceiveLayout $value)
 */
class Product extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.common.Product)
  
  /**
   * @var string $product_id
   * @tag 1
   * @label required
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $product_id;
  
  /**
   * @var string $name
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $name;
  
  /**
   * @var string $url
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $url;
  
  /**
   * @var string $image
   * @tag 4
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $image;
  
  /**
   * @var string $price
   * @tag 5
   * @label optional
   * @type \ProtocolBuffers::TYPE_FLOAT
   **/
  protected $price;
  
  /**
   * @var string $original_price
   * @tag 6
   * @label optional
   * @type \ProtocolBuffers::TYPE_FLOAT
   **/
  protected $original_price;
  
  /**
   * @var string $discount
   * @tag 7
   * @label optional
   * @type \ProtocolBuffers::TYPE_FLOAT
   **/
  protected $discount;
  
  /**
   * @var string $sold
   * @tag 8
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $sold;
  
  /**
   * @var string $qty
   * @tag 9
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $qty;
  
  /**
   * @var string $specification
   * @tag 10
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $specification;
  
  /**
   * @var string $wholesaler_id
   * @tag 11
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $wholesaler_id;
  
  /**
   * @var string $wholesaler_name
   * @tag 12
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $wholesaler_name;
  
  /**
   * @var string $wholesaler_url
   * @tag 13
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $wholesaler_url;
  
  /**
   * @var string $num
   * @tag 14
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $num;
  
  /**
   * @var string $barcode
   * @tag 15
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $barcode;
  
  /**
   * @var string $first_category_id
   * @tag 16
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $first_category_id;
  
  /**
   * @var string $second_category_id
   * @tag 17
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $second_category_id;
  
  /**
   * @var string $third_category_id
   * @tag 18
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $third_category_id;
  
  /**
   * @var string $special_price
   * @tag 19
   * @label optional
   * @type \ProtocolBuffers::TYPE_FLOAT
   **/
  protected $special_price;
  
  /**
   * @var string $special_from_date
   * @tag 20
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $special_from_date;
  
  /**
   * @var string $special_to_date
   * @tag 21
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $special_to_date;
  
  /**
   * @var string $sold_qty
   * @tag 22
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $sold_qty;
  
  /**
   * @var string $real_sold_qty
   * @tag 23
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $real_sold_qty;
  
  /**
   * @var array $gallery
   * @tag 24
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $gallery;
  
  /**
   * @var string $brand
   * @tag 25
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $brand;
  
  /**
   * @var string $export
   * @tag 26
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $export;
  
  /**
   * @var string $origin
   * @tag 27
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $origin;
  
  /**
   * @var string $package_num
   * @tag 28
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $package_num;
  
  /**
   * @var string $package_spe
   * @tag 29
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $package_spe;
  
  /**
   * @var string $package
   * @tag 30
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $package;
  
  /**
   * @var string $shelf_life
   * @tag 31
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $shelf_life;
  
  /**
   * @var string $desc
   * @tag 32
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $desc;
  
  /**
   * @var string $sort_weights
   * @tag 33
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $sort_weights;
  
  /**
   * @var string $shelf_time
   * @tag 34
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $shelf_time;
  
  /**
   * @var string $created_at
   * @tag 35
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $created_at;
  
  /**
   * @var string $updated_at
   * @tag 36
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $updated_at;
  
  /**
   * @var string $status
   * @tag 37
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $status;
  
  /**
   * @var string $state
   * @tag 38
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $state;
  
  /**
   * @var array $recommend_list
   * @tag 39
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\Product
   **/
  protected $recommend_list;
  
  /**
   * @var array $parameters
   * @tag 40
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\KeyValueItem
   **/
  protected $parameters;
  
  /**
   * @var string $promotion_text_from
   * @tag 41
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $promotion_text_from;
  
  /**
   * @var string $promotion_text_to
   * @tag 42
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $promotion_text_to;
  
  /**
   * @var string $promotion_text
   * @tag 43
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $promotion_text;
  
  /**
   * @var string $product_description
   * @tag 44
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $product_description;
  
  /**
   * @var string $minimum_order
   * @tag 45
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $minimum_order;
  
  /**
   * @var string $rebates
   * @tag 46
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $rebates;
  
  /**
   * @var string $rebates_lelai
   * @tag 47
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $rebates_lelai;
  
  /**
   * @var string $rebates_wholesaler
   * @tag 48
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $rebates_wholesaler;
  
  /**
   * @var string $rebates_all
   * @tag 49
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $rebates_all;
  
  /**
   * @var array $tags
   * @tag 50
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\Tag
   **/
  protected $tags;
  
  /**
   * @var array $security_info
   * @tag 51
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\SecurityInfo
   **/
  protected $security_info;
  
  /**
   * @var string $is_calculate_lelai_rebates
   * @tag 52
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $is_calculate_lelai_rebates;
  
  /**
   * @var string $commission
   * @tag 53
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $commission;
  
  /**
   * @var string $lelai_rebates
   * @tag 54
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $lelai_rebates;
  
  /**
   * @var bool $is_collected
   * @tag 55
   * @label optional
   * @type \ProtocolBuffers::TYPE_BOOL
   **/
  protected $is_collected;
  
  /**
   * @var string $restrict_daily
   * @tag 56
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $restrict_daily;
  
  /**
   * @var string $purchased_qty
   * @tag 57
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $purchased_qty;
  
  /**
   * @var string $subsidies_wholesaler
   * @tag 58
   * @label optional
   * @type \ProtocolBuffers::TYPE_FLOAT
   **/
  protected $subsidies_wholesaler;
  
  /**
   * @var string $subsidies_lelai
   * @tag 59
   * @label optional
   * @type \ProtocolBuffers::TYPE_FLOAT
   **/
  protected $subsidies_lelai;
  
  /**
   * @var string $frequency
   * @tag 60
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $frequency;
  
  /**
   * @var string $rule_id
   * @tag 61
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $rule_id;
  
  /**
   * @var \service\message\common\CouponReceiveLayout $coupon_receive_layout
   * @tag 62
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   **/
  protected $coupon_receive_layout;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.common.Product)

  // @@protoc_insertion_point(class_scope:.service.message.common.Product)

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
        "name"     => "product_id",
        "required" => true,
        "optional" => false,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "name",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(3, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "url",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(4, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "image",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(5, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_FLOAT,
        "name"     => "price",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(6, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_FLOAT,
        "name"     => "original_price",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(7, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_FLOAT,
        "name"     => "discount",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(8, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "sold",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(9, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "qty",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(10, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "specification",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(11, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "wholesaler_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(12, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "wholesaler_name",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(13, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "wholesaler_url",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(14, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "num",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(15, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "barcode",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(16, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "first_category_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(17, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "second_category_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(18, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "third_category_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(19, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_FLOAT,
        "name"     => "special_price",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(20, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "special_from_date",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(21, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "special_to_date",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(22, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "sold_qty",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(23, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "real_sold_qty",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(24, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "gallery",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(25, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "brand",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(26, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "export",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(27, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "origin",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(28, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "package_num",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(29, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "package_spe",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(30, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "package",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(31, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "shelf_life",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(32, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "desc",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(33, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "sort_weights",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(34, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "shelf_time",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(35, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "created_at",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(36, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "updated_at",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(37, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "status",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(38, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "state",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(39, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "recommend_list",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\Product',
      )));
      $desc->addField(40, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "parameters",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\KeyValueItem',
      )));
      $desc->addField(41, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "promotion_text_from",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(42, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "promotion_text_to",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(43, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "promotion_text",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(44, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "product_description",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(45, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "minimum_order",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(46, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "rebates",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(47, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "rebates_lelai",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(48, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "rebates_wholesaler",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(49, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "rebates_all",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(50, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "tags",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\Tag',
      )));
      $desc->addField(51, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "security_info",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\SecurityInfo',
      )));
      $desc->addField(52, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "is_calculate_lelai_rebates",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(53, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "commission",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(54, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "lelai_rebates",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(55, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_BOOL,
        "name"     => "is_collected",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => false,
      )));
      $desc->addField(56, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "restrict_daily",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(57, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "purchased_qty",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(58, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_FLOAT,
        "name"     => "subsidies_wholesaler",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(59, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_FLOAT,
        "name"     => "subsidies_lelai",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(60, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "frequency",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(61, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "rule_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(62, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "coupon_receive_layout",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\CouponReceiveLayout',
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.common.Product)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}