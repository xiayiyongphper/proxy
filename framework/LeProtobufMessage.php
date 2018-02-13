<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/8
 * Time: 17:06
 */
namespace framework;


abstract class LeProtobufMessage extends \ProtobufMessage
{

	public function toArray(){
		return $this->values;
	}

}