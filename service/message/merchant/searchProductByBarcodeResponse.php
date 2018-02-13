<?php
namespace service\message\merchant;

// @@protoc_insertion_point(namespace:.service.message.merchant.searchProductByBarcodeResponse)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: merchant/searchProductByBarcodeResponse.proto
 *
 * -*- magic methods -*-
 *
 * @method array getBarcodeSearchResult()
 * @method void appendBarcodeSearchResult(\service\message\common\Thematic $value)
 */
class searchProductByBarcodeResponse extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.merchant.searchProductByBarcodeResponse)
  
  /**
   * @var array $barcode_search_result
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   * @see \service\message\common\Thematic
   **/
  protected $barcode_search_result;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.merchant.searchProductByBarcodeResponse)

  // @@protoc_insertion_point(class_scope:.service.message.merchant.searchProductByBarcodeResponse)

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
        "name"     => "barcode_search_result",
        "required" => false,
        "optional" => false,
        "repeated" => true,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\Thematic',
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.merchant.searchProductByBarcodeResponse)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
