<?php
namespace service\components;

use common\models\Products;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * public function
 */
class Tools
{

    public static function getCategoryByProducts($productList){
        // map
        $storeHas = array();
        foreach ($productList as $key => $item) {
            $value = $item;
            $hash = $value['first_category_id'] . '|' . $value['second_category_id'] . '|' . $value['third_category_id'];
            $storeHas[$hash] = 1;
        }
        //print_r(json_encode($storeHas));

        // PMS全树
        $pmsCategory = Tools::proCate();
        $pmsCategory = [
            'id'=>1,
            'parent_id'=>0,
            'name'=>'Root',
            'path'=>'1',
            'level'=>'0',
            'child_category'=>$pmsCategory,
        ];

        foreach ($pmsCategory['child_category'] as $index => $fc) {

            // 有儿子分类则继续
            if (is_array($fc['child_category']) || count($fc['child_category'])) {

                foreach ($fc['child_category'] as $index_2 => $sc) {
                    // 有儿子分类则继续
                    if (is_array($sc['child_category']) || count($sc['child_category'])) {
                        foreach ($sc['child_category'] as $index_3 => $tc) {
                            $hash = $fc['id'] . '|' . $sc['id'] . '|' . $tc['id'];
                            //原来的过滤分类
                            if (!isset($storeHas[$hash])) {
                                unset($pmsCategory['child_category'][$index]['child_category'][$index_2]['child_category'][$index_3]);
                            }else{
                                // 本身最小的子分类儿子节点去掉
                                unset($pmsCategory['child_category'][$index]['child_category'][$index_2]['child_category'][$index_3]['child_category']);
                            }

                        }
                    }
                    // 儿子被删光了,本身也干掉
                    if (!count($pmsCategory['child_category'][$index]['child_category'][$index_2]['child_category'])) {
                        unset($pmsCategory['child_category'][$index]['child_category'][$index_2]);
                    }
                }
            }
            // 儿子被删光了,本身也干掉
            if (!count($pmsCategory['child_category'][$index]['child_category'])) {
                unset($pmsCategory['child_category'][$index]);
            }
        }

        // 去掉key值，避免ios客户端崩掉getStoreProductDetail
        $pmsCategory['child_category'] = array_values($pmsCategory['child_category']);
        foreach ($pmsCategory['child_category'] as $index => $fc) {
            $pmsCategory['child_category'][$index]['child_category'] = array_values($pmsCategory['child_category'][$index]['child_category']);
            foreach ($pmsCategory['child_category'][$index]['child_category'] as $index_2 => $sc) {
                $pmsCategory['child_category'][$index]['child_category'][$index_2]['child_category'] = array_values($pmsCategory['child_category'][$index]['child_category'][$index_2]['child_category']);
            }
        }

        // 写缓存
        //$redis->set($cacheKey, serialize($pmsCategory['child_category']), 600);// 10分钟

        return $pmsCategory;
    }

    /**
     * Function: getCategoryLevelByID
     * Author: Jason Y. Wang
     * 计算一个分类的level
     * @param $category_id
     * @return null
     */
    public static function getCategoryLevelByID($category_id){
        $categories = Redis::getPMSCategories();
        foreach($categories as $key => $category){
            $category = unserialize($category);
            if($category['id'] == $category_id){
                return $category['level'];
            }
        }
        return null;
    }

    /**
     * 取产品分类
     */

    public static function proCate()
    {
        /** @var \yii\Redis\Cache $redis */
        $redis = Yii::$app->redisCache;
        //通过SD库接口取产品分类,结果存放redis
        if ($redis->exists("pro_cate") === false) {
            $categories = Redis::getPMSCategories();
            $tree = self::collectionToArray($categories, 0);
            $redis->set("pro_cate", serialize($tree), 3600);
        }
        $category = unserialize($redis->get("pro_cate"));
        return $category[0]['child_category'];

    }


    /**
     * @param $collection
     * @param $parentId
     * @return array
     */
    protected static function collectionToArray($collection, $parentId)
    {
        $categories = array();
        foreach ($collection as $key => $category) {
            $category = unserialize($category);
            if ($category['parent_id'] == $parentId) {
                $categories[] = array(
                    'id' => $category['id'],
                    'parent_id' => $category['parent_id'],
                    'name' => $category['name'],
                    'path' => $category['path'],
                    'level' => $category['level'],
                    'child_category' => self::collectionToArray($collection, $category['id']),
                );
                unset($collection[$key]);
            }
        }
        return $categories;
    }

    /**
     * 递归取某个分类下的所有子类ID
     *
     * @param string $proclass 商品分类
     * @param int $cid 待查找子类的ID
     * @param array $child 存放被查出来的子类ID
     */
    public static function cateChild($proclass, $cid, &$child)
    {

        //k:父分类ID  v:子分类值
        foreach ($proclass as $k => $v) {
            if ($v['parent_id'] == $cid || $v['id'] == $cid) {

                $child[] = $v['id'];

                self::cateChild($v['child_category'], $v['id'], $child);

            } else {
                foreach ($v['child_category'] as $key => $val) {
                    if ($val['id'] == $cid) {
                        $child[] = $val['id'];
                    }
                }
            }
        }
    }

    /**
     * Function: getCategoryIdByCid
     * Author: Jason Y. Wang
     *根据所有分类和给定分类确定给定分类所属的一二三级分类
     * @param $cat
     * @param $cid
     * @param $child
     * @param $index
     *
     */
    public static function getCategoryIdsByCid($cat, $cid, &$child, $index = 0, &$flag = false)
    {
        //k:父分类ID  v:子分类值
        foreach ($cat as $k => $v) {
            if ($flag == true) {
                return;
            }
            $child[$index] = $v['id'];
            if ($v['id'] == $cid) {
                $flag = true;
                return;
            }
            self::getCategoryIdsByCid($v['child_category'], $cid, $child, $index + 1, $flag);
        }
    }

    /**
     * 返回当前分类ID大类目和下一级分类
     */

    public static function curCate($cid, &$curCateList)
    {

        $cate = self::proCate();
        foreach ($cate as $k => $v) {
            if ($v['id'] == $cid) {
                $curCateList['id'] = $v['id'];
                $curCateList['name'] = $v['name'];
                foreach ($v['child_category'] as $key => $val) {
                    $curCateList['child_category'][$key]['id'] = $val['id'];
                    $curCateList['child_category'][$key]['name'] = $val['name'];
                }
            } else {
                foreach ($v['child_category'] as $key => $val) {

                    if ($val['id'] == $cid) {
                        self::curCate($val['parent_id'], $curCateList);
                    }

                }
            }
        }


    }

    /**
     * 返回指定分类导航链接
     */
    public static function navCate($cid)
    {
        $curCateList = $nav = array();

        self::curCate($cid, $curCateList);

        $nav[0]['id'] = $curCateList['id'];

        $nav[0]['name'] = $curCateList['name'];
        if ($curCateList['id'] != $cid) {

            foreach ($curCateList['child_category'] as $v) {

                if ($cid == $v['id']) {

                    $nav[1]['id'] = $v['id'];

                    $nav[1]['name'] = $v['name'];

                }

            }
        }

        return $nav;
    }

    public static function numberFormat($number, $precision = 0)
    {
        return number_format($number, $precision, null, '');
    }

    /**
     * 取商品价格
     * 如果是特价商品返回特价,不然返回原价
     */
    public static function getPrice($val)
    {
        $specialPrice = $val['special_price'];
        $price = $val['price'];
        if ($specialPrice == 0) {
            $finalPrice = $price;
        } elseif ($price > $specialPrice) {
            $finalPrice = $specialPrice;
        } else {
            $finalPrice = $price;
        }
        return self::numberFormat($finalPrice, 2);
    }


    /**
     * 判断指定点经纬度是否在配送区域
     * 参照点是否在多边形内部算法
     * 方法：求解通过该点的水平线与多边形各边的交点
     * 结论：单边交点为奇数，成立!
     * $p指定点经纬度
     * $region 多边形点经纬度
     */

    public static function  ptInPolygon($p, $region)
    {
        $n = 0;
        $nCount = count($region);
        for ($i = 0; $i < $nCount; $i++) {
            $p1 = $region[$i];
            $p2 = $region[($i + 1) % $nCount];

            //求P与P1P2水平交点
            if ($p1['y'] == $p2['y']) continue;   //两点平行

            if ($p['y'] < min($p1['y'], $p2['y'])) continue;//交点在P1P2延长线

            if ($p['y'] > max($p1['y'], $p2['y'])) continue;//交点在P1P2延长线

            //求交点X的坐标
            $x = ($p['y'] - $p1['y']) * ($p2['x'] - $p1['x']) / ($p2['y'] - $p1['y']) + $p1['x'];

            if ($x > $p['x']) $n++; //统计单边交点

        }
        return ($n % 2 == 1);
    }

    public static function getImage($gallery, $size = '600x600', $single = true)
    {
        $gallery = explode(';', $gallery);
        $search = ['source', '600x600', '180x180'];
        if ($single) {
            return str_replace($search, $size, $gallery[0]);
        } else {
            $images = array();
            foreach ($gallery as $image) {
                $images[] = str_replace($search, $size, $image);
            }
            return $images;
        }
    }

    public static function formatPrice($price)
    {
        return number_format($price, 2);
    }

    /**
     * Function: getCategoryByTcids
     * Author: Jason Y. Wang
     * 根据所给的三级分类查找分类树
     * @param $ThirdCategoryIds
     * @return array
     */
    public static function getCategoryByTcids($ThirdCategoryIds)
    {
        // 在Redis中查找三级分类
        $categories = Redis::getCategories($ThirdCategoryIds);
        $collectionKeys = $collections = array();
        foreach ($categories as $key => $category) {
            $keys = explode('/', $category['path']);
            $collectionKeys = array_merge($collectionKeys, $keys);
        }
        $collectionKeys = array_unique($collectionKeys);
        if (count($collectionKeys)) {
            $collections = Redis::getCategories($collectionKeys);
        }

        $tree = self::unserializeCollectionToArray($collections, 0);
        return $tree[0]['child_category'];
    }


    /**
     * @param $collection
     * @param $parentId
     * @return array
     */
    protected static function unserializeCollectionToArray($collection, $parentId)
    {
        $categories = array();
        foreach ($collection as $key => $category) {
            if ($category['parent_id'] == $parentId) {
                $categories[] = array(
                    'id' => $category['id'],
                    'parent_id' => $category['parent_id'],
                    'name' => $category['name'],
                    'path' => $category['path'],
                    'child_category' => self::unserializeCollectionToArray($collection, $category['id']),
                );
                unset($collection[$key]);
            }
        }
        return $categories;
    }

    /**
     * Function: getCategoryBy
     * Author: Jason Y. Wang
     *  TODO:此方法需要修改，暂时不要使用
     * @param $products
     * @return array
     */
    public static function getCategoryBy($products)
    {
        //PMS中所有分类
        $pmsCategory = Tools::proCate();

        //商品中的所有三级分类
        $productCategory = array();
        /* @var $productModel ActiveQuery */
        $productCategorys = $products->select('third_category_id')->groupBy('third_category_id')->asArray()->all();
        foreach ($productCategorys as $key => $value) {
            $productCategory[] = $value['third_category_id'];
        }
        $Fcategory = $Scategory = $Tcategory = array();
        foreach ($pmsCategory as $first_key => $first_category) {
            foreach ($first_category['child_category'] as $second_key => $second_category) {
                foreach ($second_category['child_category'] as $third_key => $third_category) {
                    if (in_array($third_category['id'], $productCategory)) {
                        $Tcategory[] = $third_category;
                    }
                }
                if (count($Tcategory)) {
                    unset($second_category['child_category']);
                    $second_category['child_category'] = $Tcategory;
                    $Scategory[] = $second_category;
                    unset($Tcategory);
                }
            }
            if (count($Scategory)) {
                unset($first_category['child_category']);
                $first_category['child_category'] = $Scategory;
                $Fcategory[] = $first_category;
                unset($Scategory);
            }
        }
        return $Fcategory;
    }

	public static function getLogFilename($file)
	{
		$file = empty($file) ? 'system.log' : $file;
		$parts = explode('.', $file);
		$ext = array_pop($parts);
		array_push($parts, date('Y-m-d'));
		array_push($parts, $ext);
		$file = implode('.', $parts);
		return $file;
	}

	public static function getLogPath()
	{
		return \Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'runtime' . DIRECTORY_SEPARATOR . 'logs';
	}

    public static function log($data,$filename = null)
    {
		if (!$filename) {
			$filename = 'system.log';
		}
		$filename = self::getLogFilename($filename);
		$date = new Date();
		$file = self::getLogPath() . DIRECTORY_SEPARATOR . $filename;
		file_put_contents($file, '[' . $date->date() . '] ' . print_r($data, true) . PHP_EOL, FILE_APPEND);
    }

    /**
     * @param \Exception $e
     * @param null $filename
     */
    public static function logException($e,$filename = null)
    {
        if(!$filename){
            $filename = 'exception.log';
        }
        $date = new Date();
        $file = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . $filename;
        file_put_contents($file, '['.$date->date().'] '.$e->__toString() . PHP_EOL, FILE_APPEND);
    }

    public static function logToFile($data,$filename){
        $file = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . $filename;
        file_put_contents($file, $data);
    }

    /**
     * @return \common\redis\Cache
     * @throws \yii\base\InvalidConfigException
     */
    public static function getRedis(){
        return Yii::$app->get('redisCache');
    }

    public static function getSphinx(){
        return Yii::$app->get('sphinx');
    }

}