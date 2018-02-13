<?php
namespace service\message\merchant;

// @@protoc_insertion_point(namespace:.service.message.merchant.ContractorMerchantRequest)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: merchant/ContractorMerchantRequest.proto
 *
 * -*- magic methods -*-
 *
 * @method string getContractorId()
 * @method void setContractorId(\string $value)
 * @method string getAuthToken()
 * @method void setAuthToken(\string $value)
 * @method \service\message\common\Pagination getPagination()
 * @method void setPagination(\service\message\common\Pagination $value)
 * @method string getKeyWord()
 * @method void setKeyWord(\string $value)
 */
class ContractorMerchantRequest extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.merchant.ContractorMerchantRequest)
  
  /**
   * @var string $contractor_id
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT64
   **/
  protected $contractor_id;
  
  /**
   * @var string $auth_token
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $auth_token;
  
  /**
   * @var \service\message\common\Pagination $pagination
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_MESSAGE
   **/
  protected $pagination;
  
  /**
   * @var string $key_word
   * @tag 4
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $key_word;
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.merchant.ContractorMerchantRequest)

  // @@protoc_insertion_point(class_scope:.service.message.merchant.ContractorMerchantRequest)

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
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "auth_token",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(3, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_MESSAGE,
        "name"     => "pagination",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
        "message" => '\service\message\common\Pagination',
      )));
      $desc->addField(4, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "key_word",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      // @@protoc_insertion_point(builder_scope:.service.message.merchant.ContractorMerchantRequest)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}