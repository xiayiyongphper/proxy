<?php
namespace service\message\common;

// @@protoc_insertion_point(namespace:.service.message.common.TagGroup)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: common/TagGroup.proto
 *
 * -*- magic methods -*-
 *
 * @method string getGroupName()
 * @method void setGroupName(\string $value)
 * @method array getTags()
 * @method void appendTags(\service\message\common\Tag $value)
 */
class TagGroup extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.common.TagGroup)
  
  /**
   * @var string $group_name
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $group_name;
  
  /**
   * @var array $tags
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\Tag
   **/
  protected $tags;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.common.TagGroup)

  // @@protoc_insertion_point(class_scope:.service.message.common.TagGroup)

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
        "name"     => "group_name",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "tags",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\Tag',
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.common.TagGroup)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}