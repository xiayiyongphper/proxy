<?php
namespace framework;

use framework\components\Date;
use framework\components\Debug;
use framework\components\es\Collectd;
use framework\components\es\Console;
use framework\components\es\Timeline;
use service\components\Tools;
use service\message\common\ResponseHeader;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/8
 * Time: 16:19
 */

/**
 * Class Application
 * @package framework
 */
class Application extends \yii\base\Application
{
    protected $serverConfig = [];
    /**
     * @var \swoole_server
     */
    protected $server;
    protected $processes = [];
    protected $host;
    protected $port;
    protected $localHost;
    protected $localPort;
    protected $msgHost;
    protected $msgPort;
    public $resources = [];
    const OPTION_APPCONFIG = 'appconfig';
    /**
     * @var Request
     */
    protected $_handleRequest;

    /**
     * @param Request $request
     * @return \framework\Response
     * @throws Exception
     */
    public function handleRequest($request)
    {
        /** @var \service\message\common\Header $header */
        list ($header, $params) = $request->resolve();
        $this->_handleRequest = $request;
        $this->requestedRoute = $header->getRoute();
        $result = $this->runAction($header, $params);
        return $result;
    }

    /**
     * Runs a controller action specified by a route.
     * This method parses the specified route and creates the corresponding child module(s), controller and action
     * instances. It then calls [[Controller::runAction()]] to run the action with the given parameters.
     * If the route is empty, the method will use [[defaultRoute]].
     * @param string $route the route that specifies the action.
     * @param array $params the parameters to be passed to the action
     * @return array
     */
    public function runAction($route, $params = [])
    {
        $timeStart = microtime(true);
        /** @var \service\message\common\Header $header */
        $date = new Date();
        $header = $route;
        $methodName = 'run';
        $responseHeader = new ResponseHeader();
        $responseHeader->setTimestamp($date->date());
        $responseHeader->setCode(0);
        $responseHeader->setRoute($header->getRoute());
        $data = false;
        if ($header->getRequestId()) {
            $responseHeader->setRequestId($header->getRequestId());
        }
        $this->log($header->getTraceId());
        try {
            $className = $this->getResource($header->getRoute(), $header->getVersion());
            /** @var  \service\resources\ResourceAbstract $model */
            $model = new $className();
            if (method_exists($model, $methodName)) {
                /** @var \ProtocolBuffers\Message $data */
                $model->setHeader($header);
                $model->setRequest($this->_handleRequest);
                $data = $model->$methodName($params);
            } else {
                Exception::invalidRequestRoute();
            }
        } catch (\Exception $e) {
            if ($e->getCode() > 0) {
                $responseHeader->setCode($e->getCode());
            } else {
                $responseHeader->setCode(999);
            }
            $responseHeader->setMsg($e->getMessage());
            $this->logException($e, $header->getTraceId());
        }
        $timeEnd = microtime(true);
        $elapsed = $timeEnd - $timeStart;
        Timeline::get()->report($header->getRoute(), 'runAction', ENV_SYS_NAME, $elapsed, $responseHeader->getCode(), $header->getTraceId(), $header->getRequestId());
        return [$responseHeader, $data];
    }

    public function getResource($route, $version)
    {
        $parts = explode('.', $route);
        $version = 'v' . $version;
        if (count($parts) == 2) {
            $path = $parts[0];
            $fileName = $parts[1];
            if (isset($this->resources[$path])) {
                return $this->resources[$path] . '\\' . $version . '\\' . $fileName;
            } else {
                Exception::resourceNotFound();
            }
        } else {
            Exception::invalidRequestRoute();
        }
    }

    /**
     * Returns the request component.
     * @return Request the request component.
     */
    public function getRequest()
    {
        return $this->get('request');
    }

    public function onConnect($server, $fd)
    {
        $this->log("Client:Connect. client id: " . $fd);
    }

    public function onClose($server, $fd)
    {
        $this->log("Client: Close.");
    }

    public function onFinish(\swoole_server $server, $task_id, $data)
    {
        $this->log("Task#$task_id finished, data_len=" . strlen($data));
    }

    public function onShutdown(\swoole_server $server)
    {
        $this->log('Server shutdown');
    }

    public function onWorkerStop(\swoole_server $server, $worker_id)
    {
        $this->log("Worker stop:{$worker_id}");
    }

    public function onWorkerError(\swoole_server $server, $worker_id, $worker_pid, $exit_code)
    {
        $this->log("onWorkerError.worker_id:{$worker_id},worker_pid:{$worker_pid},exit_code:{$exit_code}");
    }

    public function onManagerStop(\swoole_server $server)
    {
        $this->log('onManagerStop');
    }

    public function registerShutdownFunction()
    {
        $error = error_get_last();
        if (isset($error['type'])) {
            $this->log($error);
        }
        $this->log(Debug::backtrace(true, false));
    }

    public function onStart(\swoole_server $server)
    {
        try {
            swoole_set_process_name(self::getProcessNamePrefix() . ':Master-' . $server->master_pid);
        } catch (\Exception $e) {

        }
        $this->log("MasterPid={$server->master_pid}|Manager_pid={$server->manager_pid}");
        $this->log("Server: start.Swoole version is [" . SWOOLE_VERSION . "]");
    }

    public function onWorkerStart(\swoole_server $server, $worker_id)
    {
        if ($worker_id == 0) {
            $this->reload($server);
            $this->collectd($server);
        }
        if ($server->taskworker) {
            try {
                swoole_set_process_name(self::getProcessNamePrefix() . ':Task Worker-' . $worker_id);
            } catch (\Exception $e) {

            }
        } else {
            try {
                swoole_set_process_name(self::getProcessNamePrefix() . ':Worker-' . $worker_id);
            } catch (\Exception $e) {

            }
        }
    }

    protected function collectd(\swoole_server $server)
    {
        swoole_timer_tick(30000, function () use ($server) {
            Collectd::get()->report('connections_count', count($server->connections));
        });
    }

    protected function reload(\swoole_server $server)
    {
        $file = \Yii::getAlias('@service') . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'reload';
        swoole_timer_tick(10000, function () use ($server, $file) {
            if (!file_exists($file)) {
                file_put_contents($file, 0);
                chmod($file, 0777);
                $this->log('Reset reload file.');
            } else {
                $data = file_get_contents($file);
                if (intval($data) === 1) {
                    $this->log('Reload command received,server begin to reload.');
                    $server->reload();
                    file_put_contents($file, 0);
                    $this->log('Reset reload file.');
                }
            }
        });
    }

    public function onManagerStart(\swoole_server $server)
    {
        try {
            swoole_set_process_name(self::getProcessNamePrefix() . ':Manager Process-' . $server->manager_pid);
        } catch (\Exception $e) {

        }
        $this->log('onManagerStart-' . $server->manager_pid);
    }

    protected function log($data)
    {
        Console::get()->log($data);
    }

    protected function logException(\Exception $e, $traceId = null)
    {
        Console::get()->logException($e, $traceId);
        Tools::logException($e);
    }

    public static function getProcessNamePrefix()
    {
        return 'RPC ' . ENV_SYS_NAME . ' Server';
    }
}