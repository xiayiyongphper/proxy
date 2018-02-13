<?php
namespace service\resources;
use service\components\Tools;
use service\components\Proxy;
use service\message\common\Header;
use service\message\common\SourceEnum;
use service\message\customer\CustomerAuthenticationRequest;
use service\message\customer\CustomerResponse;
use yii\base\Component;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/21
 * Time: 15:10
 */
abstract class ResourceAbstract
{
    protected $_client;
    protected $_traceId;
    /**
     * @var bool
     */
    protected $_remote;

    /**新增
     * @var \service\message\common\Header
     */
    private $_header;

    /**新增
     * @var \service\Request
     */
    private $_request;

    /**
     * 仅当客返回值为\ProtocolBuffers\Message类型时，消息才能传递到客户端
     * @param string $data
     * @return mixed
     */
    public abstract function run($data);

    /*
     * return the instance of request class
     * @return \ProtocolBuffersMessage
     */
    public static function request()
    {
    }

    /*
     * return the instance of response class
     * @return \ProtocolBuffersMessage
     */
    public static function response()
    {
    }


    /**
     * @param \ProtocolBuffers\Message $data
     *
     * @return CustomerResponse
     * @throws \Exception
     */
    protected function _initCustomer($data)
    {

        $request = new CustomerAuthenticationRequest();
        $request->setAuthToken($data->getAuthToken());
        $request->setCustomerId($data->getCustomerId());
        $header = new Header();
        $header->setSource(SourceEnum::CORE);
        $header->setRoute('customers.customerAuthentication');
        $header->setTraceId($this->getTraceId());
        $message = Proxy::sendRequest($header, $request);
        $response = CustomerResponse::parseFromString($message->getPackageBody());
        return $response;
    }

    /**修改
     * @return mixed
     */
    public function getTraceId()
    {
        return $this->_header->getTraceId();
    }

    public function init()
    {
        $this->initEvents();
        parent::init();
    }

    public function initEvents()
    {
        if (isset(\Yii::$app->params['events'])) {
            $events = \Yii::$app->params['events'];
            foreach ($events as $eventName => $observers) {
                foreach ($observers as $observerKey => $observer) {
                    $class = $observer['class'];
                    $method = $observer['method'];
                    $this->on($eventName, [$class, $method]);
                }
            }
        } else {
            Tools::log('param events not found in config');
        }
    }

    /**新增
     * @param $header
     * @return $this
     */
    public function setHeader($header)
    {
        $this->_header = $header;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isRemote()
    {
        return $this->_request->isRemote();
    }

    /**新增
     * @param $request
     * @return $this
     */
    public function setRequest($request)
    {
        $this->_request = $request;
        return $this;
    }
}