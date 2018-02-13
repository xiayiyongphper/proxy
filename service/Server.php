<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/8
 * Time: 17:06
 */
namespace service;

use frontend\models\DeviceConfig;
use frontend\models\FakePortMap;
use frontend\models\Log;
use frontend\models\ReourceMap;
use frontend\models\UnknownDevice;
use service\components\Date;
use service\components\Proxy;
use service\components\Tools;
use service\message\common\Header;
use service\message\common\ResponseHeader;
use service\message\common\SourceEnum;
use service\message\core\FetchRouteRequest;
use service\message\core\FetchRouteResponse;
use framework\message\Message;
use \common\models\TStringFuncFactory;
use service\resources\Exception;


class Server extends Application
{
    protected $_logFile = 'swoole.log';

    // proxy服务器的地址
    protected $_host = "0.0.0.0";// serve()会更新此ip
    protected $_port = 9091;
    
    // 返回给客户端假route的IP
    protected $_proxy_ip = "172.16.10.250";// 应该和上面的host保持一致, serve()会更新此ip

    /*
     * show请求路由表
     * '客户端ip'=>'代理ip'
     */
    protected $deviceMap = [
        //// zgr手机官网版
        //'f3a040e05418688983b02c347886f0cb' => array(
        //    'charles'=>'172.16.10.250:8888',
        //    'environment'=>'product',
        //),
        //// zgr手机企业版
        //'c37d303558ccbdc6f275c935cace7216' => array(
        //    'charles'=>'172.16.10.250:8888',
        //    'environment'=>'201',
        //),

    ];

    /*
     * show请求路由表
     * '客户端ip'=>'代理ip'
     */
    protected $phoneMap = [
        // zxj手机
        '172.16.10.215' => '172.16.10.236:8888',
        // 浩发手机
        '172.16.10.237' => '172.16.10.238:8888',
        // 颜巧华为手机
        '172.16.10.204' => '172.16.10.113:8888',
    ];

    // 真的资源列表
    protected $_resourceMapping = array();
    // 假的资源列表
    protected $_fakeResourceMapping = array();
    // portMap
    protected $_fakePortMap = array();

    // show的配置
    protected $_proxy_show_path = '/frontend/web/proxy_show/';
    protected $_proxy_show_url = 'proxy.laile.com/proxy_show';//此为203的配置,serve()会更新为mac的配置


    /**
     * @var \swoole_atomic
     */
    protected $_taskNum;

    /** @var $_server \swoole_server */
    protected $_server = null;
    protected $_serverConfig = [];
    protected $_defaultServerConfig = [
        'worker_num' => 8,   //工作进程数量
        'task_worker_num' => 2,
        'daemonize' => false, //是否作为守护进程
        'log_file' => '/home/henryzhu/swoole_log/swoole.log',
        'open_length_check' => true, //打开包长检测
        'package_max_length' => 8192000, //最大的请求包长度,8M
        'package_length_type' => 'N', //长度的类型，参见PHP的pack函数
        'package_length_offset' => 0,   //第N个字节是包长度的值
        'package_body_offset' => 4,   //从第几个字节计算长度
    ];

    public function __construct($config = [])
    {
        parent::__construct($config);
        $serverConfig = \Yii::$app->params['soa_server_config'];
        if (!is_array($serverConfig)) {
            $serverConfig = [];
        }
        $this->_serverConfig = array_merge($this->_defaultServerConfig, $serverConfig);
    }

    public function onStart(\swoole_server $server) {
        echo '服务器启动: ' . date('Y-m-d H:i:s') . PHP_EOL;
        try{
            swoole_set_process_name('proxyServer');
        }catch(\Exception $e){

        }
    }

    public function onWorkerStart(\swoole_server $server, $worker_id)
    {
        if (!$server->taskworker) {
            echo "服务器worker启动(id:{$worker_id}): " . date('Y-m-d H:i:s') . PHP_EOL;
            try {
                swoole_set_process_name('proxyServerWorker');
            } catch (\Exception $e) {

            }
        }else{
            echo "服务器TaskWorker启动(id:{$worker_id}): " . date('Y-m-d H:i:s') . PHP_EOL;
            try {
                swoole_set_process_name('proxyServerTaskWorker');
            } catch (\Exception $e) {

            }
        }

        // 只有当worker_id为0时才执行,避免重复
        if($worker_id==0){

            $thus = $this;

            //// 每秒钟更新deviceap
            //swoole_timer_tick(1000, function () use ($thus) {
            //    $thus->initDeviceMap($thus);
            //});
            //// 每小时更新service
            //swoole_timer_tick(1000*3600, function () use ($thus) {
            //    $thus->initRouteFetch();
            //});


        }





    }

    public function initRouteFetch()
    {
        $this->log('initRouteFetch');
        // 加载真的资源列表
        $request = new FetchRouteRequest();
        $request->setAuthToken(Proxy::ROUTE_FETCH_TOKEN);
        $header = new Header();
        $header->setSource(SourceEnum::MERCHANT);
        $header->setRoute(Proxy::ROUTE_ROUTE_FETCH);

        // 获取所有环境下的route
        $environments = \Yii::$app->params['proxy'];
        // 所有的services
        $services = array();
        // 假的service
        $fakeIp = $this->_proxy_ip;
        $fakePort = 10001;
        // 获取所有service,并且声成假的map
        foreach ($environments as $environment=>$config) {
            $this->log($environment);
            if(isset($config['app_version'])){
                $header->setAppVersion($config['app_version']);
            }else{
                $header->clear('app_version');
            }
            $message = Proxy::sendRequest($header, $request, true, $environment);
            if ($message->getHeader()->getCode() > 0) {
                throw new \Exception($message->getHeader()->getMsg(), $message->getHeader()->getCode());
            }
            /** @var FetchRouteResponse $response */
            $response = FetchRouteResponse::parseFromString($message->getPackageBody());
            $this->log($response);
            // 处理返回
            $fake = [];
            $real = [];
            foreach ($response->getServices() as $service) {
                // map,用于定位真实请求
                $this->_fakePortMap[$fakePort] = array(
                    'fake_port'=>$fakePort,
                    'module'=>$service->getModule(),
                    'ip'=>$service->getIp(),
                    'port'=>$service->getPort(),
                );

                // 假map,要区分环境,用于返回给客户端假services的
                $fake[] = array(
                    'module'=>$service->getModule(),
                    'ip'=>$fakeIp,
                    'port'=>$fakePort,
                );
                array_push($services, $service);

                // 真map,没什么卵用
                $real[] = array(
                    'module'=>$service->getModule(),
                    'ip'=>$service->getIp(),
                    'port'=>$service->getPort(),
                );
                $fakePort++;
            }
            $this->_resourceMapping[$environment] = $real;
            $this->_fakeResourceMapping[$environment] = $fake;
        }
        //$this->log('ddd');

        // _fakePortMap存档
        // 删老的
        $m = new FakePortMap();
        $m->deleteAll();
        // 存新的
        foreach ($this->_fakePortMap as $item) {
            $m = new FakePortMap();
            $m->setAttributes($item, false);
            $m->insert(false);
            //$this->log($item);
        }

        // $this->_fakeResourceMapping[$environment] = $fake;
        // 删老的
        $m = new ReourceMap();
        $m->deleteAll();
        // 存新的
        $this->log($this->_fakeResourceMapping);
        foreach ($this->_fakeResourceMapping as $environment=>$item) {
            $m = new ReourceMap();
            $m->setAttributes([
                'environment'=>$environment,
                'data'=>json_encode($item),
            ], false);
            $m->insert(false);
        }

        
        $this->log("real:");
        //$this->log($this->_resourceMapping);
        //$this->log("fake:");
        //$this->log($this->_fakeResourceMapping);
        //$this->log("fakePortMap:");
        //$this->log($this->_fakePortMap);

    }

    public function initDeviceMap(){
        $m = new DeviceConfig();
        $devices = $m->find()->all();
        $map = [];
        foreach ($devices as $device) {
            $deviceId = $device->getAttribute('device_id');
            $map[$deviceId] = $device->toArray();
        }
        $this->deviceMap = $map;
        //$this->log("Device Map Refreshed:");
        //$this->log($this->deviceIdMap);
        return $map;
    }

    public function onReceive(\swoole_server $server, $fd, $from_id, $data)
    {
        $connection = $server->connection_info($fd, $fd);
        echo "[Server]: Receive [{$connection['remote_ip']}:{$connection['remote_port']}]<->to:[{$connection['server_port']}]" . PHP_EOL;
        //echo 'data:'.PHP_EOL.json_encode($data).PHP_EOL;

        // route.fetch单独返回
        if($connection['server_port'] == $this->_port) {

            $this->log("route.fetch Request");

            try {
                // 模拟解析请求
                $request = $this->getRequest()->setRawBody($data)->setFd($fd)->setRemote(true)->setServer($server);
                /** @var \service\message\common\Header $header */
                list ($header, $params) = $request->resolve();

                // 根据客户端环境返回相应的假services
                $deviceId = $header->getDeviceId();
                $environment = $this->getClientEnvironment($deviceId);
                // 获取所有设备列表
                $this->deviceMap = $this->initDeviceMap();
                // 不存在则记下来
                if(!isset($this->deviceMap[$deviceId])){
                    $this->recordUnknownDevice($deviceId);
                }
                // 是否需要抓包
                $is_capture = 0;
                if(isset($this->deviceMap[$deviceId])
                    && $this->deviceMap[$deviceId]['is_capture'] == 1
                ){
                    $is_capture = 1;
                }
                if($is_capture){
                    // 需要抓包的设备则返回假的map
                    $routeData = array(
                        'services'=>$this->_fakeResourceMapping[$environment],
                    );
                }else{
                    // 否则直接返回真实的线上map
                    $routeData = array(
                        'services'=>$this->_resourceMapping[$environment],
                    );
                }

                // 返回数据
                $response = new FetchRouteResponse();

                $response->setFrom($routeData);

                $this->log($routeData);

                $responseHeader = new ResponseHeader();
                $responseHeader->setTimestamp(date('Y-m-d H:i:s'));
                $responseHeader->setCode(0);
                $responseHeader->setRoute($header->getRoute());
                if ($header->getRequestId()) {
                    $responseHeader->setRequestId($header->getRequestId());
                }

                // 返回给客户端
                $server->send($fd, Message::pack($responseHeader, $response));

            } catch (\Exception $e) {
                $this->log($e->getMessage());
            }


        }else{
            if($this->_taskNum->get()>100){
                $this->error($server, $fd, [
                    'code' => 999,
                    'message'  => 'Too many task, try later!',
                ]);
                return;
            }
            // 通过请求的port得到remote ip:port
            //$this->log("proxy Request");
            if(isset($this->_fakePortMap[$connection['server_port']])){
                $remote_ip = $this->_fakePortMap[$connection['server_port']]['ip'];
                $remote_port = $this->_fakePortMap[$connection['server_port']]['port'];
                $proxy_data = array(
                    'fd'=>$fd,
                    'clientIp'=>$connection['remote_ip'],
                    'ip'=>$remote_ip,
                    'port'=>$remote_port,
                    'requestData'=>$data,
                );
                $server->task($proxy_data);
            }else{
                $this->log("unknow port:".$connection['server_port']);
            }


        }

    }

    public function onClose(\swoole_server $server, $fd)
    {
        $udpClient = $server->connection_info($fd, $fd);
        //echo "[Server]: Client Close [{$udpClient['remote_ip']}:{$udpClient['remote_port']}]<->to:[{$udpClient['server_port']}]" . PHP_EOL;
    }

    public function onTask(\swoole_server $server, $task_id, $from_id, $taskData)
    {
        //echo "[Server]: Task:#{$task_id}". PHP_EOL;
        $this->_taskNum->add(1);
        //$this->log("[Server]: Task Num = ".$this->_taskNum->get());

        // 来源
        $clientIp = $taskData['clientIp'];
        $ip = $taskData['ip'];
        $port = $taskData['port'];
        $requestData = $taskData['requestData'];
        $fd = $taskData['fd'];

        // 模拟解析请求
        $request = $this->getRequest()->setRawBody($requestData)->setFd($fd)->setRemote(true)->setServer($server);
        list ($header, $params) = $request->resolve();
        /** @var \service\message\common\Header $header */
        //$this->log("request:".json_encode($params));

        // 同步客户端发代理请求
        $proxyClient = new \swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_SYNC);
        $proxyClient->set(array(
            'open_length_check'     => 1,
            'package_length_type'   => 'N',
            'package_length_offset' => 0,       //第N个字节是包长度的值
            'package_body_offset'   => 4,       //第几个字节开始计算长度
            'package_max_length'    => 2000000,  //协议最大长度
            'socket_buffer_size'    => 1024 * 1024 * 2, //2M缓存区

        ));
        $proxyClient->connect($ip, $port, 5);

        // 代理
        $res = $proxyClient->send($requestData);
        while (!$res){
            sleep(1);
            $res = $proxyClient->send($requestData);
        }
        $responseData = $proxyClient->recv();

        //$proxyClient->close();
        //$this->log("----------------------------------------------------");
        //$this->log("receivePack:".$header->getRequestId());

        // 拆包,重新组装requestId
        $message = new Message();
        $message->unpackResponse($responseData);
        // 返回包头
        $responseHeader = $message->getHeader();
        // 返回包体
        $responseBody = $message->getPackageBody();

        // 解析包体
        // 分析请求头
        $proxyRequest = [];
        $proxyResponse = [];
        $clientProxy = '';
        $proxy_show = '';
        $deviceId = $header->getDeviceId();
        // 不存在则记下来
        $this->deviceMap = $this->initDeviceMap();
        if($deviceId && !isset($this->deviceMap[$deviceId])){
            $this->recordUnknownDevice($deviceId);
        }
        try{
            // 处理请求
            $proxyRequest = [
                'route'=>$header->getRoute(),
                'request_info'=>[
                    'api_remote'=>$ip.':'.$port,
                    'client'=>$clientIp,
                    'device_id'=>$deviceId,
                ],
            ];
            $proxyRequest[get_class($header)] = $header->toArray();
            $className = $this->getResource($header->getRoute(), $header->getVersion());
            if(class_exists($className)){
                $model = new $className();
            }else{
                throw new \Exception('类不存在:'.$className, 404);
            }

            if($params){
                /** @var \ProtocolBuffers\Message $requestObj */
                if (method_exists($model, 'request') && is_object($model->request())) {
                    $requestObj = $model->request()->parseFromString($params);
                    $proxyRequest[get_class($requestObj)]=$requestObj;
                    $proxyRequest[get_class($requestObj)]=$requestObj->toArray();
                }else{
                    $proxyRequest["Body(unResolved)"] = $params;
                }
            } else {
                $proxyRequest['Body(empty)'] = '';
            }

            // 处理返回
            $proxyResponse = [];
            $proxyResponse[get_class($responseHeader)] = $responseHeader->toArray();
            if($responseBody){
                /** @var \ProtocolBuffers\Message $responseObj */
                if (method_exists($model, 'response') && is_object($model->response())) {
                    $responseObj = $model->response()->parseFromString($responseBody);
                    $proxyResponse[get_class($responseObj)] = $responseObj;
                    $proxyResponse[get_class($responseObj)] = $responseObj->toArray();
                }else{
                    $proxyResponse["Body(unResolved)"] = $responseBody;
                }
            } else {
                $proxyResponse['Body(empty)'] = '';
            }

        }catch (\Exception $e){
            $this->log($e->getMessage());
            $traces = explode(PHP_EOL, $e->getTraceAsString());
            $trace = [];
            foreach ($traces as $item) {
                $line = explode(' ', $item);
                $key = array_shift($line);
                $value = implode(' ', $line);
                $trace[$key] = $value;
            }
            $proxyResponse = [
                'msg'=>$e->getMessage(),
                'trace'=>$trace
            ];
        }

        // 发到charles
        // http://proxy.laile.com:8080/index.php
        // 若未定义则发回原机8888端口
        // 先看deviceIdMap
        if($deviceId && isset($this->deviceMap[$deviceId])){
            $clientProxy = $this->deviceMap[$deviceId]['charles'];
        }else{
            $clientProxy = isset($this->phoneMap[$clientIp]) ? $this->phoneMap[$clientIp] : $clientIp.':8888';
        }
        
        // 填了才用charles
        if($clientProxy){
            // 暂存响应
            $fileName = md5(json_encode($proxyRequest)).'.txt';
            file_put_contents($this->_proxy_show_path.'data'.DIRECTORY_SEPARATOR.$fileName, serialize($proxyResponse));
            $proxy_show = 'http://'.$this->_proxy_show_url.'/index.php?cmd='.$header->getRoute();
            sendRequest(json_encode($proxyRequest), $proxy_show, $clientProxy);
        }

        // 记录到log表
        $date = new Date();
        $logModel = new Log();
        $logModel->setAttributes([
            'device_id'=>$deviceId,
            'route'=>$header->getRoute(),
            'client'=>$clientIp,
            'api_remote'=>$ip.':'.$port,
            'charles'=>$clientProxy,
            'proxy_show'=>$proxy_show,
            'request'=>json_encode($proxyRequest),
            'response'=>json_encode($proxyResponse),
            'created_at'=>$date->date(),
        ]);

        $logModel->insert(false);
        //$this->log($logModel->toArray());

        // 原包返回
        $server->send($fd, $responseData);

        // 简要信息
        $this->log("===========================================================");
        $this->log("client     : ".$clientIp."  deviceId: ".$deviceId);
        $this->log("route      : ".$header->getRoute()."  api remote : ".$ip.':'.$port);
        $this->log("charles    : ".$clientProxy);
        $this->log("proxy_show : ".$proxy_show);
        $this->log("-----------------------------------------------------------");

        // 详情
        $this->log("===========================================================", 'api.log');
        $this->log("client     : ".$clientIp."  deviceId: ".$deviceId, 'api.log');
        $this->log("route      : ".$header->getRoute()."  api remote : ".$ip.':'.$port, 'api.log');
        $this->log("charles    : ".$clientProxy, 'api.log');
        $this->log("proxy_show : ".$proxy_show, 'api.log');
        $this->log("-----------------------------------------------------------", 'api.log');
        $this->log("Request:", 'api.log');
        $this->log($proxyRequest, 'api.log');
        $this->log("Response:", 'api.log');
        $this->log($proxyResponse, 'api.log');
        $this->log("===========================================================", 'api.log');

        $server->finish('-CALL');
    }

    public function onFinish(\swoole_server $server, $task_id, $data)
    {
        //echo "[Server]: Finish:Task#$task_id finished, data_len=" . strlen($data) . PHP_EOL;
        $this->_taskNum->sub(1);
        //$this->log("[Server]: Task Num = ".$this->_taskNum->get());
    }

    public function serve()
    {
        // 本机ip
        $ip = exec('ifconfig|grep inet|grep -v inet6|grep -v "127.0.0.1"|awk \'{print $2}\'|sed \'s/addr://g\'|head -1');
        //$this->log($ip);
        //$ip = '172.16.10.239';
        if($ip){
            $this->_host = $ip;
            $this->_proxy_ip = $ip;
        }

        $this->_proxy_show_path = __DIR__.'/../frontend/web/proxy_show/';

        //// 自己机器,host的ip就改为本机
        //if(strpos(php_uname(), 'MacBook')){
        //    $this->_proxy_show_url = 'proxy.laile.com/proxy_show';
        //}

        $this->_server = new \swoole_server($this->_host, $this->_port);

        $this->initRouteFetch();
        foreach ($this->_fakePortMap as $port=>$item) {
            // 监听本地假端口
            $this->log("add:".$this->_host.":".$port);
            $this->_server->addlistener($this->_host, $port, SWOOLE_SOCK_TCP);
        }

        //
        $this->_taskNum = new \swoole_atomic(0);
        $this->_server->set($this->_serverConfig);
        $this->_server->on('start', array($this, 'onStart'));
        $this->_server->on('WorkerStart', array($this, 'onWorkerStart'));
        $this->_server->on('WorkerStop', array($this, 'onWorkerStop'));
        $this->_server->on('connect', [$this, 'onConnect']);
        $this->_server->on('receive', [$this, 'onReceive']);
        $this->_server->on('close', [$this, 'onClose']);
        $this->_server->on('task', [$this, 'onTask']);
        $this->_server->on('finish', [$this, 'onFinish']);

        $res = $this->_server->start();

        if ($res){
            $this->log("su");
        }else{
            $this->log("fa");
        }
    }

    public function onWorkerStop(\swoole_server $server, $worker_id)
    {
        if (!$server->taskworker) {
            echo "服务器worker停止({$worker_id}): " . date('Y-m-d H:i:s') . PHP_EOL;
        }else{
            echo "服务器task worker停止({$worker_id}): " . date('Y-m-d H:i:s') . PHP_EOL;
        }
    }

    public function onConnect(\swoole_server $server, $fd)
    {
        $udpClient = $server->connection_info($fd, $fd);
        echo "[Server]: New [{$udpClient['remote_ip']}:{$udpClient['remote_port']}]<->to:[{$udpClient['server_port']}]" . PHP_EOL;
    }

    /**
     * 带重试机制的send方法.
     *
     * @param int            $retry_time
     * @param \swoole_server $server
     * @param                $fd
     * @param                $data
     */
    public function reSend($retry_time = 1, \swoole_server $server, $fd, $data)
    {
        if ($retry_time > 3) {
            // 三次不成功,丢弃
            $this->log("Server: Send out of time error!");
            $server->close($fd);
        } else {
            // 发送
            $this->log("Server: Send :".$data);
            $send_result = $server->send($fd, $data);
            if (!$send_result) {
                $server->after(1000 * $retry_time, function () use ($retry_time, $server, $fd, $data) {
                    $this->reSend($retry_time + 1, $server, $fd, $data);
                });
            } else {
                // 成功了才close
                // $server->close($fd);
            }
        }
    }

    /*
	 * deamon模式则打到文件,否则输出到屏幕
	 */
    protected function log($data, $logFile=null)
    {
        if (isset($this->_serverConfig['daemonize']) && $this->_serverConfig['daemonize']) {
            // 默认文件地址
            if(!$logFile){
                $logFile = $this->_logFile;
            }
            Tools::log($data, $logFile);
        } else {
            $date = new Date();
            echo '[' . $date->date() . '] ' . print_r($data, true) . PHP_EOL;
        }

    }

    public function unpack($data)
    {
        return TStringFuncFactory::create()->substr($data, 4);
    }

    public function pack($json)
    {
        return pack('N', TStringFuncFactory::create()->strlen($json)) . $json;
    }

    public function getResource($route, $version)
    {
        $version = "v".$version;
        $parts = explode('.', $route);
        if (count($parts) == 2) {
            $path = $parts[0];
            $fileName = $parts[1];
            if (isset($this->resources[$path])) {
                return $this->resources[$path] . '\\' . $version . '\\' .$fileName;
            } else {
                Exception::resourceNotFound();
            }
        } else {
            Exception::invalidRequestRoute();
        }
    }

    private function getClientEnvironment($deviceId){
        $this->deviceMap = $this->initDeviceMap();
        if(isset($this->deviceMap[$deviceId])){
            return $this->deviceMap[$deviceId]['environment'];
        }else{
            return 'product';
        }
    }

    private function recordUnknownDevice($deviceId){
        $this->log("Add unknow device:".$deviceId);
        $this->deviceMap = $this->initDeviceMap();
        //$this->log($this->deviceIdMap);
        $m = new UnknownDevice();
        $m->setAttributes([
            'device_id'=>$deviceId,
            'created_at'=>time(),
        ]);
        $m->save();
    }
}


/**
 * send request
 * @param array $data
 * @return mixed
 */
function sendRequest($data='', $url='', $proxy='')
{
    if(!$url){
        // 原api类型
        $api = isset($_GET['api'])? $_GET['api']:'';
        $url = URL . "api/rest/".$api;
    }
    $action = 'POST';
    $get = $_GET;
    unset($get['method']);
    $headers = array('Accept: application/json', 'Content-type: application/json;charset=utf-8');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_TIMEOUT, 180);
    if($proxy){
        curl_setopt($ch,CURLOPT_PROXY, $proxy);
    }
    switch ($action) {
        case 'GET':
            break;
        case 'POST':
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            break;
        case 'PUT':
        case 'DELETE':
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $action); // DELETE/PUT方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            break;
    }

    $output = curl_exec($ch);
    if ($output == false) {
        echo curl_error($ch);
    }
    curl_close($ch);
    return $output;
}