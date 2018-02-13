<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace framework;

use framework\components\es\Collectd;
use framework\components\ToolsAbstract;
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
    /**
     * @var Message
     */
    protected $_message;

    private $_rawBody;
    /**
     * @var int
     */
    private $_fd;

    /**
     * @var bool
     */
    protected $_remote;

    /**
     * @var \swoole_server
     */
    protected $_server;

    /**
     * debug mode
     * @var bool
     */
    protected $_debug = false;

    protected $_level = 0;

    const REDIS_KEY_DEBUG_DEVICE_TABLE = 'debug_device_table';

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
     * @return \framework\message\Message
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

    /**
     * @return \swoole_server
     */
    public function getServer()
    {
        return $this->_server;
    }

    /**
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
    public function isDebug()
    {
        return $this->_debug;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->_level;
    }

    /**
     * @return array
     */
    public function resolve()
    {
        $rawBody = $this->getRawBody();
        $this->_message = new Message();
        $this->_message->unpack($rawBody);
        $header = $this->_message->getHeader();

        Collectd::get()->report('pv', 1, [ENV_SYS_NAME, $header->getRoute()]);

        if ($header->getDeviceId() && ToolsAbstract::getRedis()->hExists(self::REDIS_KEY_DEBUG_DEVICE_TABLE, $header->getDeviceId())) {
            $this->_debug = true;
            $this->_level = ToolsAbstract::getRedis()->hGet(self::REDIS_KEY_DEBUG_DEVICE_TABLE, $header->getDeviceId());
            if (!$this->_level) {
                $this->_level = 1;
            }
        }
        if (!$header->getTraceId()) {
            $header->setTraceId($this->getTraceId());
        }
        $params = $this->_message->getPackageBody();
        return [$header, $params];
    }

    public function getTraceId()
    {
        return str_replace('.', '', uniqid(ENV_SYS_NAME . '_', true));
    }
}
