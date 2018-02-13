<?php
namespace service\message\syncProcess;

// @@protoc_insertion_point(namespace:.service.message.syncProcess.Status)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: syncProcess/Status.proto
 *
 */
class Status extends \ProtocolBuffers\Enum
{
  // @@protoc_insertion_point(traits:.service.message.syncProcess.Status)
  
  const NEW = 1;
  const PROCESSING = 2;
  const FAIL = 3;
  const APPLIED = 4;
  const CLOSE = 5;
  
  // @@protoc_insertion_point(const_scope:.service.message.syncProcess.Status)
  
  // @@protoc_insertion_point(class_scope:.service.message.syncProcess.Status)
  
  /**
   * @return \ProtocolBuffers\EnumDescriptor
   */
  public static function getEnumDescriptor()
  {
    static $descriptor;
    if (!$descriptor) {
      $builder = new \ProtocolBuffers\EnumDescriptorBuilder();
      $builder->addValue(new \ProtocolBuffers\EnumValueDescriptor(array(
        "value" => self::NEW,
        "name"  => 'NEW',
      )));
      $builder->addValue(new \ProtocolBuffers\EnumValueDescriptor(array(
        "value" => self::PROCESSING,
        "name"  => 'PROCESSING',
      )));
      $builder->addValue(new \ProtocolBuffers\EnumValueDescriptor(array(
        "value" => self::FAIL,
        "name"  => 'FAIL',
      )));
      $builder->addValue(new \ProtocolBuffers\EnumValueDescriptor(array(
        "value" => self::APPLIED,
        "name"  => 'APPLIED',
      )));
      $builder->addValue(new \ProtocolBuffers\EnumValueDescriptor(array(
        "value" => self::CLOSE,
        "name"  => 'CLOSE',
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.syncProcess.Status)
      $descriptor = $builder->build();
    }
    return $descriptor;
  }
}
