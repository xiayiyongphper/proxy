<?php
namespace service\message\common;

// @@protoc_insertion_point(namespace:.service.message.common.EncryptionMethod)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: common/EncryptionMethod.proto
 *
 */
class EncryptionMethod extends \ProtocolBuffers\Enum
{
  // @@protoc_insertion_point(traits:.service.message.common.EncryptionMethod)
  
  const DES = 1;
  const RSA = 2;
  
  // @@protoc_insertion_point(const_scope:.service.message.common.EncryptionMethod)
  
  // @@protoc_insertion_point(class_scope:.service.message.common.EncryptionMethod)
  
  /**
   * @return \ProtocolBuffers\EnumDescriptor
   */
  public static function getEnumDescriptor()
  {
    static $descriptor;
    if (!$descriptor) {
      $builder = new \ProtocolBuffers\EnumDescriptorBuilder();
      $builder->addValue(new \ProtocolBuffers\EnumValueDescriptor(array(
        "value" => self::DES,
        "name"  => 'DES',
      )));
      $builder->addValue(new \ProtocolBuffers\EnumValueDescriptor(array(
        "value" => self::RSA,
        "name"  => 'RSA',
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.common.EncryptionMethod)
      $descriptor = $builder->build();
    }
    return $descriptor;
  }
}