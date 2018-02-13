<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/25
 * Time: 11:38
 */
namespace common\db;

use service\components\Tools;

class Connection extends \yii\db\Connection
{
    protected $_checkInterval = 120;
    protected $_lastCheckTime = 0;

    /**
     * 另外考虑到连接效率的问题，
     * 可以设置尝试重连的时间为mysql服务器的interactive_timeout,wait_timeout时间，
     * 当时间大于该值时才去检查数据库连接。
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function check()
    {
        $this->log(__METHOD__);
        $elapse = time() - $this->_lastCheckTime;
        //的时间小于最小检查间隔时间则不进行检查
        if ($elapse < $this->_checkInterval) {
            $this->log('no need to check connection');
            return true;
        }

        try {
            if (!$this->pdo) {
                $this->open();
                $this->log('PDO init connection');
            }
            $info = $this->pdo->getAttribute(\PDO::ATTR_SERVER_INFO);
            if (preg_match('/[a-zA-Z]+:\s+\d+\.?\d+/', $info, $matches)) {
                $this->log($info);
                $this->log('PDO connected');
                $this->_lastCheckTime = time();
            } else {
                $this->reconnect();
            }
        } catch (\PDOException $e) {
            $this->log('PDOException reconnect');
            $this->reconnect();
        } catch (\Exception $e) {
            $this->log('Exception  reconnect');
            $this->reconnect();
        }
    }

    protected function reconnect()
    {
        $this->close();
        $this->open();
        $this->_lastCheckTime = time();
        $info = $this->pdo->getAttribute(\PDO::ATTR_SERVER_INFO);
        if (preg_match('/[a-zA-Z]+:\s+\d+\.?\d+/', $info, $matches)) {
            $this->log('PDO reconnect after_:' . $info);
        } else {
            $this->log('PDO reconnect failed:' . $info);
        }
    }

    protected function log($msg)
    {
        Tools::log($msg, 'connection.log');
    }
}