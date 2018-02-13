<?php
namespace service\models;

use service\components\Tools;
use service\message\common\Header;
use service\message\common\SourceEnum;
use service\message\core\ConfigRequest;
use service\message\core\ConfigResponse;
use service\message\core\FetchRouteRequest;
use service\message\core\HomeRequest;
use service\message\merchant;
use framework\message\Message;
use service\models\client\ClientAbstract;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/8
 * Time: 12:01
 */
class SOAClient extends ClientAbstract
{
    public $responseClass = null;
    public $model = 'merchant';
    public $method = null;

    protected $_customer = 35;
    protected $_authToken = 'KBovpuxTtPUbhq28';

    public function onReceive($client, $data)
    {
        //echo "[Client]: Receive:". $data . PHP_EOL;
        $message = new Message();
        $message->unpackResponse($data);
        if ($message->getHeader()->getCode() > 0) {
            echo '[Client]:程序执行异常：', $message->getHeader()->getMsg() . PHP_EOL;
        } else {
            $responseClass = $this->responseClass;
            $response = $responseClass::parseFromString($message->getPackageBody());
            echo "[Client]: Receive:" . PHP_EOL;
            print_r($response->toArray());
            echo PHP_EOL;
        }
        //$this->close();
    }

    public function merchant_getStoreDetail()
    {
        $this->responseClass = 'service\message\common\Store';
        $request = new merchant\getStoreDetailRequest();
        $request->setWholesalerId(1);
        $header = new Header();
        $header->setSource(SourceEnum::MERCHANT);
        $header->setRoute('merchant.getStoreDetail');
        $this->send(Message::pack($header, $request));
    }

    public function merchant_getStoresByAreaIds()
    {
        $this->responseClass = 'service\message\merchant\getStoresByAreaIdsResponse';
        $request = new merchant\getStoresByAreaIdsRequest();
        $request->appendAreaIds(5);
        $header = new Header();
        $header->setSource(SourceEnum::MERCHANT);
        $header->setRoute('merchant.getStoresByAreaIds');
        $this->send(Message::pack($header, $request));
    }

    public function merchant_getProduct()
    {
        $this->responseClass = 'service\message\merchant\getProductResponse';
        $request = new merchant\getProductRequest();
        $request->setWholesalerId(1);
        $request->appendProductIds(137);
        $request->appendProductIds(122);
        $header = new Header();
        $header->setSource(SourceEnum::MERCHANT);
        $header->setRoute('merchant.getProduct');
        $this->send(Message::pack($header, $request));
    }

    public function merchant_getAreaBrand()
    {
        $this->responseClass = 'service\message\merchant\getAreaBrandResponse';
        $request = new merchant\getAreaBrandRequest();
        $request->setWholesalerId(1);
        $request->setCategoryId(103);
        $request->setCategoryLevel(1);
        $request->setCustomerId($this->_customer);
        $request->setAuthToken($this->_authToken);
        $header = new Header();
        $header->setSource(SourceEnum::MERCHANT);
        $header->setRoute('merchant.getAreaBrand');
        $this->send(Message::pack($header, $request));
    }

    public function merchant_getAreaCategory()
    {
        $this->responseClass = 'service\message\common\CategoryNode';
        $request = new merchant\getAreaCategoryRequest();
        //$request->setWholesalerId(1);
        $request->setCustomerId(1091);
        $request->setAuthToken('jSXGDG6SqYvPUuwO');
        //$request->setWholesalerId(1);
        $header = new Header();
        $header->setSource(SourceEnum::MERCHANT);
        $header->setRoute('merchant.getAreaCategory');
        $this->send(Message::pack($header, $request));
    }

    public function merchant_reduceQty()
    {
        $this->responseClass = 'service\message\merchant\reduceQtyResponse';
        $request = new merchant\reduceQtyRequest();
        $request->setFrom([
            'customer_id' => 72,
            'auth_token' => 'FOwLs6prG2g8JTYz',
            'products' => [
                [
                    'wholesaler_id' => 1,
                    'product_id' => 1,
                    'num' => 1,
                ],
                [
                    'wholesaler_id' => 1,
                    'product_id' => 2,
                    'num' => 2,
                ],
                [
                    'wholesaler_id' => 3,
                    'product_id' => 1,
                    'num' => 4,
                ],
            ],
        ]);
        $header = new Header();
        $header->setSource(SourceEnum::MERCHANT);
        $header->setRoute('merchant.reduceQty');
        $this->send(Message::pack($header, $request));
    }

    public function merchant_home()
    {
        $this->responseClass = 'service\message\core\HomeResponse';
        $homeReq = new HomeRequest();
        $homeReq->setCustomerId($this->_customer);
        $homeReq->setAuthToken($this->_authToken);
        $header = new Header();
        $header->setSource(SourceEnum::MERCHANT);
        $header->setVersion(1);
        $header->setRoute('merchant.home');
        $data = Message::pack($header, $homeReq);
        Tools::logToFile($data, 'home.dat');
        $this->send($data);
    }

    public function merchant_home2()
    {
        $this->responseClass = 'service\message\core\HomeResponse';
        $homeReq = new HomeRequest();
        $homeReq->setCustomerId($this->_customer);
        $homeReq->setAuthToken($this->_authToken);
        $header = new Header();
        $header->setSource(SourceEnum::MERCHANT);
        $header->setVersion(1);
        $header->setRoute('merchant.home2');
        $data = Message::pack($header, $homeReq);
        Tools::logToFile($data, 'home.dat');
        $this->send($data);
    }

    public function getTopic()
    {
        $this->responseClass = 'service\message\merchant\thematicActivityResponse';
        $thematicActivity = new merchant\thematicActivityRequest();
        $thematicActivity->setCustomerId($this->_customer);
        $thematicActivity->setAuthToken($this->_authToken);
        $thematicActivity->setIdentifier('featured_product_list');
        $header = new Header();
        $header->setSource(SourceEnum::MERCHANT);
        $header->setVersion(1);
        $header->setRoute('merchant.getTopic');
        $data = Message::pack($header, $thematicActivity);
        Tools::logToFile($data, 'home.dat');
        $this->send($data);
    }

    public function onConnect($client)
    {
        echo "[Client]: Connected to server." . PHP_EOL;
        $argv = $_SERVER['argv'];
        if (count($argv) == 2) {
            $method = $argv[1];
            if (method_exists($this, $method)) {
                $this->$method();
            } else {
                $class = new \ReflectionClass('service\models\SOAClient');
                $methods = $class->getMethods();
                echo 'Callable methods:' . PHP_EOL;
                foreach ($methods as $index => $method) {
                    echo $index . ':' . $method->getName() . PHP_EOL;
                }
                echo sprintf('Total:%s', count($methods)) . ' method(s)' . PHP_EOL;
            }
        } else {
            $this->route();
        }
    }

    public function merchant_searchProduct()
    {
        $this->responseClass = 'service\message\merchant\searchProductResponse';
        $request = new merchant\searchProductRequest();
        $request->setCustomerId($this->_customer);
        $request->setAuthToken($this->_authToken);
        $request->setWholesalerId(2);
        $request->setKeyword('统一');
        $request->setPage(1);
        //$request->setField('sold_qty');
        $request->setField('price');
        $request->setSort('asc');
//		$request->setSort('DESC');
        //$request->setPageSize(1);
        //$request->setCategoryId(80);
        //$request->setCategoryLevel(1);
        $header = new Header();
        $header->setSource(SourceEnum::MERCHANT);
        $header->setRoute('merchant.searchProduct');
        $this->send(Message::pack($header, $request));
    }

    public function core_config()
    {
        $this->responseClass = 'service\message\core\ConfigResponse';
        $request = new ConfigRequest();
        $request->setVer('1');
        $header = new Header();
        $header->setSource(SourceEnum::MERCHANT);
        $header->setRoute('core.config');
        $this->send(Message::pack($header, $request));
    }


    public function route()
    {
        $this->responseClass = 'service\message\core\FetchRouteResponse';
        $request = new FetchRouteRequest();
        $request->setAuthToken('yggBfivOTkMOFNDm');
        $header = new Header();
        $header->setSource(SourceEnum::MERCHANT);
        $header->setRoute('route.fetch');
        $this->send(Message::pack($header, $request));
    }

}