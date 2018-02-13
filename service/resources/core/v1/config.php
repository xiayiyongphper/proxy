<?php
/**
 * Created by Jason.
 * Author: Jason Y. Wang
 * Date: 2016/2/3
 * Time: 14:56
 */

namespace service\resources\core\v1;


use service\components\Tools;
use service\message\core\ConfigRequest;
use service\message\core\ConfigResponse;
use service\resources\ResourceAbstract;

class config extends ResourceAbstract
{
    /**
     * Function: run
     * Author: Jason Y. Wang
     * 获取配置信息,IOS，ANDROID,IOS企业通过channel或system进行区分
     * @param string $data
     * @return ConfigResponse
     */
    public function run($data)
    {
        /** @var ConfigRequest $request */
        $request = ConfigRequest::parseFromString($data);
        $response = new ConfigResponse();
        $response->setCsh('4008949580');
        $response->setAdShowTime(5);
		$response->setHelperUrl('http://assets.lelai.com/assets/h5/help/index.html');
		$response->setWalletHelperUrl('http://assets.lelai.com/assets/h5/help/detail.html?cid=wallet');
        $response->setCouponHelperUrl('http://assets.lelai.com/assets/h5/help/detail.html?cid=coupon');
        $response->setVer(1);
        $response->setJsCart('http://assets.lelai.com/assets/cart/cart.html?version=17');
        if ($this->isDebug()) {
            $response->setDebug(true);
            $options = [['key' => 'edit_url', 'value' => '1'],];
            if (defined('ENV_LOG_SERVER_IP') && defined('ENV_LOG_SERVER_PORT')) {
                switch ($this->getLevel()) {
                    case 1:
                        break;
                    case 2:
                        $options[] = ['key' => 'api', 'value' => '1'];
                        $options[] = ['key' => 'ip', 'value' => ENV_LOG_SERVER_IP];
                        $options[] = ['key' => 'port', 'value' => ENV_LOG_SERVER_PORT];
                        break;
                    case 3:
                    case 4:
                    case 5:
                    case 6:
                    case 7:
                    case 8:
                    case 9:
                    default:
                        $options[] = ['key' => 'api', 'value' => '1'];
                        $options[] = ['key' => 'console_exception', 'value' => '1'];
                        $options[] = ['key' => 'ip', 'value' => ENV_LOG_SERVER_IP];
                        $options[] = ['key' => 'port', 'value' => ENV_LOG_SERVER_PORT];
                }
            }
            if (count($options) > 0) {
                $response->setFrom(['debug_options' => $options]);
            }
        }
        return $response;
    }

    public static function request()
    {
        return new ConfigRequest();
    }

    public static function response()
    {
        return new ConfigResponse();
    }
}
