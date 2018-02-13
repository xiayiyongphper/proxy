<?php 
namespace common\components;

use common\Mathematics\Point;
use common\models\RegionArea;
use common\Mathematics\Algorithm\Polygon;
use service\message\common\Product;
use service\message\common\Store;
use service\message\merchant\getProductRequest;
use service\message\merchant\getProductResponse;
use service\message\merchant\getStoreDetailRequest;
use service\models\common\CustomerException;
use Yii;

/**
* public function
*/
class UserTools 
{
    //生成随机数
    const CHARS_LOWERS                          = 'abcdefghijklmnopqrstuvwxyz';
    const CHARS_UPPERS                          = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const CHARS_DIGITS                          = '0123456789';

	/**
	  * 加密解密函数
	  */
	public static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {   
	    // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙   
	    $ckey_length = 4;   
	       
	    // 密匙   
	    $key = md5($key ? $key : 'lelai_pcweb');   
	       
	    // 密匙a会参与加解密   
	    $keya = md5(substr($key, 0, 16));   
	    // 密匙b会用来做数据完整性验证   
	    $keyb = md5(substr($key, 16, 16));   
	    // 密匙c用于变化生成的密文   
	    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): 
	substr(md5(microtime()), -$ckey_length)) : '';   
	    // 参与运算的密匙   
	    $cryptkey = $keya.md5($keya.$keyc);   
	    $key_length = strlen($cryptkey);   
	    // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)， 
	//解密时会通过这个密匙验证数据完整性   
	    // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确   
	    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) :  
	sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;   
	    $string_length = strlen($string);   
	    $result = '';   
	    $box = range(0, 255);   
	    $rndkey = array();   
	    // 产生密匙簿   
	    for($i = 0; $i <= 255; $i++) {   
	        $rndkey[$i] = ord($cryptkey[$i % $key_length]);   
	    }   
	    // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度   
	    for($j = $i = 0; $i < 256; $i++) {   
	        $j = ($j + $box[$i] + $rndkey[$i]) % 256;   
	        $tmp = $box[$i];   
	        $box[$i] = $box[$j];   
	        $box[$j] = $tmp;   
	    }   
	    // 核心加解密部分   
	    for($a = $j = $i = 0; $i < $string_length; $i++) {   
	        $a = ($a + 1) % 256;   
	        $j = ($j + $box[$a]) % 256;   
	        $tmp = $box[$a];   
	        $box[$a] = $box[$j];   
	        $box[$j] = $tmp;   
	        // 从密匙簿得出密匙进行异或，再转成字符   
	        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));   
	    }   
	    if($operation == 'DECODE') {  
	        // 验证数据有效性，请看未加密明文的格式   
	        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) &&  
	substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {   
	            return substr($result, 26);   
	        } else {   
	            return '';   
	        }   
	    } else {   
	        // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因   
	        // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码   
	        return $keyc.str_replace('=', '', base64_encode($result));   
	    }   
	}

	/**
	 * 通过超市经纬找出这个超市所在的area ID
	 * @param $lng
	 * @param $lat
	 * @return array|bool
	 */
	public static function findAreaIdByLocation($lat,$lng){
		$areaId = 0;
		if ($lat && $lng) {
			$areas = (new RegionArea())->find();
			//根据最大最小经纬度粗略查找所在区域
			$areas->where(['<','min_lat',$lat])->andWhere(['>','max_lat',$lat])
				  ->andWhere(['<','min_lng',$lng])->andWhere(['>','max_lng',$lng]);
			$areasOne = $areas->asArray()->all();
			foreach ($areasOne as $key => $item) {
				//精细查找
				if (static::whetherInTheRange($lat, $lng,$item)) {
					//运营保证区域ID不重合，一个超市只能属于一个区域ID
					//发现匹配的区域后，直接退出循环
					//如果后面也有匹配区域暂时不做处理
					$areaId = $item['entity_id'];
					break;
				}
			}
		}
		return $areaId;
	}

	/**
	 *
	 * 确认超市是否在区域，有时间看下这里的算法
	 * @param $lat
	 * @param $lng
	 * @param $item
	 * @return bool
	 */
	public static function whetherInTheRange($lat, $lng,$item)
	{
		//TODO:有时间看看这里的算法
		$point = new Point($lng, $lat);
		$regions = unserialize($item['polygon']);
		$flag = false;

		foreach ($regions as $region) {
			$points = explode(';', $region['coordinates']);
			$polygon = new Polygon($point);
			foreach ($points as $onePoint) {
				$pointArray = explode(',', $onePoint);
				$new_point = new Point($pointArray[0], $pointArray[1]);
				$polygon->addPoint($new_point);
			}
			if ($polygon->pointInPolygon()) {
				$flag = true;
				break;
			}
		}
		return $flag;
	}

	/**
	 * Function: getStoreInfo
	 * Author: Jason Y. Wang
	 *
	 * @param $wholesaler_id
	 * @return Store
	 * @throws CustomerException
	 */
	public static function getStoreInfoByProxy($wholesaler_id){
		//初始化店铺
		$storeDetailRequest = new getStoreDetailRequest();
		$storeDetailRequest->setWholesalerId($wholesaler_id);
		$response = Proxy::sendRequest('merchant.getStoreDetail',$storeDetailRequest);
		/** @var Store $store */
		//得到店铺信息
		$store = Store::parseFromString($response->getPackageBody());
		return $store;

	}

	/**
	 * Function: getProductsByProxy
	 * Author: Jason Y. Wang
	 * 得到单个商品信息
	 * @param $wholesaler_id
	 * @param $product_id
	 * @return Product
	 * @throws CustomerException
	 */
	public static function getProductsByProxy($wholesaler_id,$product_id){
		//请求商品信息
		$productRequest = new getProductRequest();
		$productRequest->setWholesalerId($wholesaler_id);
		$productRequest->appendProductIds($product_id);
		$productResult = Proxy::sendRequest('merchant.getProduct',$productRequest);
		//得到商品信息
		/** @var getProductResponse $productResponse */
		$productResponse = getProductResponse::parseFromString($productResult->getPackageBody());
		$productListResponse = $productResponse->getProductList();
		/** @var Product $product */
		$product = $productListResponse[0];
		return $product;
	}

	public static function formatFormData(&$data){
        if(count($data)){
            foreach($data as $key => $value){
                if($value === null){
                    unset($data[$key]);
                }
            }
        }
    }

    public static function getRandomString($len, $chars = null)
    {
        if (is_null($chars)) {
            $chars = self::CHARS_LOWERS . self::CHARS_UPPERS . self::CHARS_DIGITS;
        }
        for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++) {
            $str .= $chars[mt_rand(0, $lc)];
        }
        return $str;
    }

}