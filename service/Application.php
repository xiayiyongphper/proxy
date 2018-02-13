<?php
namespace service;

use service\components\Logger;
use service\components\Tools;
use service\message\common\ResponseHeader;
use service\resources\Exception;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/8
 * Time: 16:19
 */
class Application extends \yii\base\Application
{
	
	const OPTION_APPCONFIG = 'appconfig';
	public $resources = [];
	/**
	 * @var \service\Request
	 */
	protected $_handleRequest;

	/**
	 * @param \yii\base\Request $request
	 *
	 * @return int|\yii\console\Response|\yii\web\Response
	 * @throws Exception
	 */
	public function handleRequest($request)
	{
		/** @var \service\message\common\Header $header */
		list ($header, $params) = $request->resolve();
		$this->_handleRequest = $request;
		$this->requestedRoute = $header->getRoute();
		echo "[Server]: route: " . $this->requestedRoute . PHP_EOL;
		$result = $this->runAction($header, $params);
		Tools::log(print_r($result, true), 'log/response/'.$this->requestedRoute.'.log');
		return $result;
	}

	/**
	 * Runs a controller action specified by a route.
	 * This method parses the specified route and creates the corresponding child module(s), controller and action
	 * instances. It then calls [[Controller::runAction()]] to run the action with the given parameters.
	 * If the route is empty, the method will use [[defaultRoute]].
	 *
	 * @param string $route  the route that specifies the action.
	 * @param array  $params the parameters to be passed to the action
	 *
	 * @return mixed the result of the action.
	 * @throws InvalidRouteException if the requested route cannot be resolved into an action successfully
	 */
	public function runAction($route, $params = [])
	{

		/** @var \service\message\common\Header $header */
		$header = $route;
		$methodName = 'run';
		$responseHeader = new ResponseHeader();
		$responseHeader->setTimestamp(date('Y-m-d H:i:s'));
		$responseHeader->setCode(0);
		$responseHeader->setRoute($header->getRoute());
		$data = false;
		if ($header->getRequestId()) {
			$responseHeader->setRequestId($header->getRequestId());
		}
		echo "[Server]: TraceId->[" . $header->getTraceId() . "]" . PHP_EOL;
		try {
			$className = $this->getResource($header->getRoute(), $header->getVersion());
			/** @var  \service\resources\ResourceAbstract $model */
			$model = new $className();
			if (method_exists($model, $methodName)) {
				echo "[Server]: Receive data";
				if (method_exists($model, 'request') && $model->request()) {
					/** @var \ProtocolBuffers\Message $requestObj */
					$requestObj = $model->request()->parseFromString($params);
					echo "(resolved):" . get_class($requestObj) . PHP_EOL;
					echo print_r($requestObj->toArray(), true) . PHP_EOL;
				} else {
					echo "(unResolved):" . PHP_EOL;
					echo print_r($params, true) . PHP_EOL;
				}
				/** @var \ProtocolBuffers\Message $data */
				$model->setHeader($header);//修改
				$model->setRequest($this->_handleRequest);//修改
				$data = $model->$methodName($params);
				if(is_object($data)){
					Logger::log($header->getTraceId(),$data->jsonSerialize());
				}
			} else {
				Exception::invalidRequestRoute();
			}
		} catch (\Exception $e) {
			echo "[Server]: run ERROR! ".$e->getMessage().'('.$e->getCode().')'.PHP_EOL;
			echo "[Server]: trace".$e->getTraceAsString();
			$responseHeader->setCode($e->getCode());
			$responseHeader->setMsg($e->getMessage());
			Logger::log($header->getTraceId(), $e);
		}

		return [$responseHeader, $data];
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

	/**
	 * Returns the request component.
	 * @return \yii\web\Request|\yii\console\Request|\service\Request the request component.
	 */
	public function getRequest()
	{
		return $this->get('request');
	}
}