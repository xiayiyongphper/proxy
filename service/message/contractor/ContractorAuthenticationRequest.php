<?php
namespace service\message\contractor;

// @@protoc_insertion_point(namespace:.service.message.contractor.ContractorAuthenticationRequest)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: contractor/ContractorAuthenticationRequest.proto
 *
 * -*- magic methods -*-
 *
 * @method string getContractorId()
 * @method void setContractorId(\string $value)
 * @method string getAuthToken()
 * @method void setAuthToken(\string $value)
 */
class ContractorAuthenticationRequest extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.service.message.contractor.ContractorAuthenticationRequest)
  
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
  
  
  // @@protoc_insertion_point(properties_scope:.service.message.contractor.ContractorAuthenticationRequest)

  // @@protoc_insertion_point(class_scope:.service.message.contractor.ContractorAuthenticationRequest)

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
      // @@protoc_insertion_point(builder_scope:.service.message.contractor.ContractorAuthenticationRequest)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
