<?php
namespace service\message\common;

// @@protoc_insertion_point(namespace:.service.message.common.QuickEntryModule)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: common/QuickEntryModule.proto
 *
 * -*- magic methods -*-
 *
 * @method array getQuickEntryBlocks()
 * @method void appendQuickEntryBlocks(\service\message\common\QuickEntryBlock $value)
 * @method \service\message\common\Image getBackgroundImg()
 * @method void setBackgroundImg(\service\message\common\Image $value)
 */
class QuickEntryModule extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.common.QuickEntryModule)
  
  /**
   * @var array $quick_entry_blocks
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\QuickEntryBlock
   **/
  protected $quick_entry_blocks;
  
  /**
   * @var \service\message\common\Image $background_img
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   **/
  protected $background_img;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.common.QuickEntryModule)

  // @@protoc_insertion_point(class_scope:.service.message.common.QuickEntryModule)

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
        "name"     => "quick_entry_blocks",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\QuickEntryBlock',
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "background_img",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\Image',
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.common.QuickEntryModule)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
