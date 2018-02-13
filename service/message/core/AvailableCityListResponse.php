<?php
namespace service\message\core;

// @@protoc_insertion_point(namespace:.service.message.core.AvailableCityListResponse)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: core/AvailableCityListResponse.proto
 *
 * -*- magic methods -*-
 *
 * @method array getCity()
 * @method void appendCity(\service\message\common\City $value)
 */
class AvailableCityListResponse extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.core.AvailableCityListResponse)
  
  /**
   * @var array $city
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\City
   **/
  protected $city;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.core.AvailableCityListResponse)

  // @@protoc_insertion_point(class_scope:.service.message.core.AvailableCityListResponse)

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
        "name"     => "city",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\City',
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.core.AvailableCityListResponse)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}