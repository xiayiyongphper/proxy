<?php
namespace service\message\contractor;

// @@protoc_insertion_point(namespace:.service.message.contractor.CreateCustomerIntentionRequest)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: contractor/CreateCustomerIntentionRequest.proto
 *
 * -*- magic methods -*-
 *
 * @method string getContractorId()
 * @method void setContractorId(\string $value)
 * @method string getAuthToken()
 * @method void setAuthToken(\string $value)
 * @method string getBusinessLicenseNo()
 * @method void setBusinessLicenseNo(\string $value)
 * @method string getAreaId()
 * @method void setAreaId(\string $value)
 * @method string getAddress()
 * @method void setAddress(\string $value)
 * @method string getDetailAddress()
 * @method void setDetailAddress(\string $value)
 * @method string getStoreName()
 * @method void setStoreName(\string $value)
 * @method string getStorekeeper()
 * @method void setStorekeeper(\string $value)
 * @method string getPhone()
 * @method void setPhone(\string $value)
 * @method string getLat()
 * @method void setLat(\string $value)
 * @method string getLng()
 * @method void setLng(\string $value)
 * @method array getType()
 * @method void appendType(\string $value)
 * @method string getLevel()
 * @method void setLevel(\string $value)
 * @method string getBusinessLicenseImg()
 * @method void setBusinessLicenseImg(\string $value)
 * @method string getStoreFrontImg()
 * @method void setStoreFrontImg(\string $value)
 * @method string getCity()
 * @method void setCity(\string $value)
 * @method string getStorekeeperInstoreTimes()
 * @method void setStorekeeperInstoreTimes(\string $value)
 * @method string getImgLat()
 * @method void setImgLat(\string $value)
 * @method string getImgLng()
 * @method void setImgLng(\string $value)
 */
class CreateCustomerIntentionRequest extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.contractor.CreateCustomerIntentionRequest)
  
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
   * @var string $business_license_no
   * @tag 3
   * @label required
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $business_license_no;
  
  /**
   * @var string $area_id
   * @tag 4
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $area_id;
  
  /**
   * @var string $address
   * @tag 5
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $address;
  
  /**
   * @var string $detail_address
   * @tag 6
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $detail_address;
  
  /**
   * @var string $store_name
   * @tag 7
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $store_name;
  
  /**
   * @var string $storekeeper
   * @tag 8
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $storekeeper;
  
  /**
   * @var string $phone
   * @tag 9
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $phone;
  
  /**
   * @var string $lat
   * @tag 10
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $lat;
  
  /**
   * @var string $lng
   * @tag 11
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $lng;
  
  /**
   * @var array $type
   * @tag 14
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $type;
  
  /**
   * @var string $level
   * @tag 15
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $level;
  
  /**
   * @var string $business_license_img
   * @tag 16
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $business_license_img;
  
  /**
   * @var string $store_front_img
   * @tag 17
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $store_front_img;
  
  /**
   * @var string $city
   * @tag 18
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $city;
  
  /**
   * @var string $storekeeper_instore_times
   * @tag 19
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $storekeeper_instore_times;
  
  /**
   * @var string $img_lat
   * @tag 20
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $img_lat;
  
  /**
   * @var string $img_lng
   * @tag 21
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $img_lng;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.contractor.CreateCustomerIntentionRequest)

  // @@protoc_insertion_point(class_scope:.service.message.contractor.CreateCustomerIntentionRequest)

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
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "business_license_no",
        "required" => true,
        "optional" => false,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(4, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "area_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(5, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "address",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(6, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "detail_address",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(7, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "store_name",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(8, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "storekeeper",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(9, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "phone",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(10, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "lat",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(11, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "lng",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(14, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "type",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(15, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT64,
        "name"     => "level",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(16, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "business_license_img",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(17, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "store_front_img",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(18, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "city",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(19, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "storekeeper_instore_times",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(20, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "img_lat",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(21, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "img_lng",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.contractor.CreateCustomerIntentionRequest)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
