<?php
namespace service\message\sync;

// @@protoc_insertion_point(namespace:.service.message.sync.Table)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: sync/Table.proto
 *
 * -*- magic methods -*-
 *
 * @method string getTableName()
 * @method void setTableName(\string $value)
 * @method string getPrimaryKey()
 * @method void setPrimaryKey(\string $value)
 * @method string getUniqueKey()
 * @method void setUniqueKey(\string $value)
 */
class Table extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.sync.Table)
  
  /**
   * @var string $table_name
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $table_name;
  
  /**
   * @var string $primary_key
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $primary_key;
  
  /**
   * @var string $unique_key
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $unique_key;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.sync.Table)

  // @@protoc_insertion_point(class_scope:.service.message.sync.Table)

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
        "name"     => "table_name",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "primary_key",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "_id",
      )));
      $desc->addField(3, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "unique_key",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.sync.Table)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
