<?php

namespace common\models;

use service\components\search\Search;
use service\components\Tools;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "products_city_440300".
 *
 * @property integer $entity_id
 * @property integer $wholesaler_id
 * @property string $lsin
 * @property string $barcode
 * @property integer $first_category_id
 * @property integer $second_category_id
 * @property integer $third_category_id
 * @property string $name
 * @property string $price
 * @property string $special_price
 * @property string $special_from_date
 * @property string $special_to_date
 * @property integer $sold_qty
 * @property integer $real_sold_qty
 * @property integer $qty
 * @property integer $minimum_order
 * @property string $gallery
 * @property string $brand
 * @property integer $export
 * @property string $origin
 * @property integer $package_num
 * @property string $package_spe
 * @property string $package
 * @property string $specification
 * @property string $shelf_life
 * @property string $description
 * @property integer $status
 * @property integer $sort_weights
 * @property string $shelf_time
 * @property string $created_at
 * @property string $updated_at
 * @property integer $state
 *
 */
class Products extends ActiveRecord
{

    //状态:1：待审核，2：审核通过，3：审核不通过，4：系统下架
    const STATE_PENDING = 1;
    const STATE_APPROVED = 2;
    const STATE_DISAPPROVED = 3;
    const STATE_DISABLED = 4;
    //状态:1：上架，2：下架
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;
    protected static $cityId;
    /** @var  Search $searchModel */
    public $searchModel;

    public function search(){
        return $this->searchModel->search();
    }

    /**
     * @param int $city_id
     * @throws \Exception
     */
    public function __construct($city_id = 0)
    {
        if ($city_id > 0) {
            self::$cityId = $city_id;
        } else {
            Yii::trace('城市ID找不到');
        }
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_city_' . self::$cityId;
    }


    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('productDb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wholesaler_id', 'lsin', 'barcode', 'first_category_id', 'second_category_id', 'third_category_id', 'name', 'price', 'special_price', 'sold_qty', 'real_sold_qty', 'qty', 'package_num', 'package_spe'], 'required'],

            [['price', 'special_price'], 'number'],
            [['special_from_date', 'special_to_date', 'shelf_time', 'created_at', 'updated_at'], 'safe'],
            [['gallery', 'specification', 'description'], 'string'],
            [['lsin'], 'string', 'max' => 32],
            [['barcode'], 'string', 'max' => 48],
            [['name'], 'string', 'max' => 128],
            [['brand'], 'string', 'max' => 100],
            [['origin'], 'string', 'max' => 60],
            [['package_spe'], 'string', 'max' => 10],
            [['package'], 'string', 'max' => 20],
            [['shelf_life'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'entity_id' => 'Entity id',
            'wholesaler_id' => '批发商',
            'lsin' => '平台唯一商品代码',
            'barcode' => '条码',
            'first_category_id' => '一级分类',
            'second_category_id' => '二级分类',
            'third_category_id' => '三级分类',
            'name' => '商品名称',
            'price' => '商品价格',
            'special_price' => '商品特价',
            'special_from_date' => '特价开始时间',
            'special_to_date' => '特价截止时间',
            'sold_qty' => '展示销量',
            'real_sold_qty' => '实际销量',
            'qty' => '库存数量',
            'gallery' => '商品相册',
            'brand' => '品牌',
            'export' => 'Export',
            'origin' => '产地',
            'package_num' => '打包内含物件数',
            'package_spe' => '包装的单件规格，如“瓶”',
            'package' => '包装',
            'specification' => '规格',
            'shelf_life' => '保质期',
            'description' => '描述',
            'status' => '状态:1：上架，2：下架',
            'sort_weights' => '权重',
            'shelf_time' => '上架时间',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'state' => '状态:1：待审核，2：审核通过，3：审核不通过，4：系统下架',
        ];
    }

    public static function convertArray($data, $isDetailPage = false)
    {
        $price = $data['price'];
        $finalPrice = Tools::getPrice($data);

        $discount = 1 - ($price - $finalPrice) / $price;
        $discount = $discount * 10;
        $discount = round($discount, 1);

        $name = self::getProductNameText($data);
        $specification = self::getProductSpecificationText($data);

        $_data = [
            "product_id" => $data['entity_id'],
            "name" => $name,
            "url" => '',
            "image" => $data['gallery'],
            "price" => $finalPrice,
            "original_price" => Tools::formatPrice($price),
            'discount' => $discount,
            "sold" => $data['sold_qty'],
            'qty' => $data['qty'],
            'specification' => $specification,
            'wholesaler_id' => $data['wholesaler_id'],
            "wholesaler_name" => "",
            "wholesaler_url" => "",
        ];
        if ($isDetailPage) {
            $_data = array_merge($data,$_data);
        }
        return array_filter($_data);
    }

    static public function getProductNameText($data){
        $name = '';
        if (isset($data['brand'])) {
            $name .= $data['brand'];
        }

        if (isset($data['name'])) {
            $name .= $data['name'];
        }

        $specification = self::getProductSpecificationText($data);
        if ($specification) {
            $name .= $specification;
        }
        return $name;
    }

    /**
     * 根据$productModel拼接产品规格信息
     *
     * @param \yii\base\Model $productObj
     *
     * @return string
     */
    static public function getProductSpecificationText($data)
    {

        $num = $data['specification'];		// 70ml
        $spe = $data['package_spe'];		// 瓶
        $num_pac = $data['package_num'];	// 5
        $spe_pac = $data['package'];		// 箱

        // "70ml"字段有斜杠,则无视"瓶"字段
        if(strpos($num, '/') !== false){
            $spe = '';
        }

        // 打包内含物数量大于1,才生效
        if($num_pac<=1){
            $num_pac = 0;
        }

        // 最终输出字串
        $specification = '';

        // 有"70ml"字段才显示规格字串
        if($num){
            // 拼接70ml
            $specification .= $num;
            // 打包内含物个数
            if($num_pac){
                // 填写了数量就要显示
                $specification .= '×'.$num_pac;
                // 最后拼单品和打包规格
                if($spe){
                    $specification .= $spe;
                }
                if($spe_pac){
                    $specification .= '/'.$spe_pac;
                }
            }else{
                // 没填内含物数量则拼单品规格
                if($spe){
                    $specification .= '/'.$spe;
                }
            }
        }

        return $specification;

    }

    public function getAttributes($names = null, $except = []){
        $data = parent::getAttributes($names, $except);
        // 处理返点的小数点问题
        $data['rebates'] = floatval($data['rebates']);
        return $data;
    }

}
