<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace service;

use service\components\Logger;
use framework\message\Message;

/**
 * The console Request represents the environment information for a console application.
 *
 * It is a wrapper for the PHP `$_SERVER` variable which holds information about the
 * currently running PHP script and the command line arguments given to it.
 *
 * @property array $params The command line arguments. It does not include the entry script name.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Request extends \yii\base\Request
{

    /**新增
     * @var \swoole_server
     */
    protected $_server;

    /**
     * @var bool
     */
    protected $_remote;

    /**
     * @var \service\message\Message
     */
    protected $_message;

    private $_rawBody;
    /**
     * @var int
     */
    private $_fd;

    /**
     * @param $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->_message = $message;
        return $this;
    }

    /**
     * @return message\Message
     */
    public function getMessage()
    {
        return $this->_message;
    }


    /**
     * Sets the raw TCP request body
     * @param $rawBody
     * @return $this
     */
    public function setRawBody($rawBody)
    {
        $this->_rawBody = $rawBody;
        return $this;
    }

    public function getRawBody()
    {
        return $this->_rawBody;
    }

    public function setFd($fd)
    {
        $this->_fd = $fd;
        return $this;
    }

    public function getFd()
    {
        return $this->_fd;
    }


    /**
     * @return array
     */
    public function resolve()
    {
        $rawBody = $this->getRawBody();
        $this->_message = new Message();
        $this->_message->unpack($rawBody);
        //$route = $this->_message->getHeader()->getRoute();
        $header = $this->_message->getHeader();
        if(!$header->getTraceId()){
            $header->setTraceId($this->getTraceId());
        }
        $params = $this->_message->getPackageBody();
        return [$header, $params];
    }

    public function getTraceId()
    {
        return str_replace('.', '', uniqid(Logger::SOURCE.'_', true));
    }

    /** 新增方法
     * @return \swoole_server
     */
    public function getServer()
    {
        return $this->_server;
    }

    /**新增方法
     * @param $server
     * @return $this
     */
    public function setServer($server)
    {
        $this->_server = $server;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isRemote()
    {
        return $this->_remote;
    }

    /**
     * @param $remote
     * @return $this
     */
    public function setRemote($remote)
    {
        $this->_remote = $remote;
        return $this;
    }

}
