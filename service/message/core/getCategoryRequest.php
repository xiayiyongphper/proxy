<?php
namespace service\message\core;

// @@protoc_insertion_point(namespace:.service.message.core.getCategoryRequest)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: core/getCategoryRequest.proto
 *
 * -*- magic methods -*-
 *
 * @method string getWholesalerId()
 * @method void setWholesalerId(\string $value)
 * @method string getCity()
 * @method void setCity(\string $value)
 */
class getCategoryRequest extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.core.getCategoryRequest)
  
  /**
   * @var string $wholesaler_id
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $wholesaler_id;
  
  /**
   * @var string $city
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $city;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.core.getCategoryRequest)

  // @@protoc_insertion_point(class_scope:.service.message.core.getCategoryRequest)

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
        "name"     => "wholesaler_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "city",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.core.getCategoryRequest)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}