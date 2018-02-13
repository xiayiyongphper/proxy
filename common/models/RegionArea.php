<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "region_area".
 *
 * @property integer $entity_id
 * @property integer $area_admin_id
 * @property string $registered_at
 * @property integer $city
 * @property integer $district
 * @property string $area_name
 * @property string $area_address
 * @property string $polygon
 * @property string $min_lng
 * @property string $max_lng
 * @property string $min_lat
 * @property string $max_lat
 */
class RegionArea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region_area';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('commonDb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_admin_id', 'registered_at', 'polygon', 'min_lng', 'max_lng', 'min_lat', 'max_lat'], 'required'],
            [['area_admin_id', 'city', 'district'], 'integer'],
            [['registered_at'], 'safe'],
            [['polygon'], 'string'],
            [['area_name'], 'string', 'max' => 120],
            [['area_address'], 'string', 'max' => 255],
            [['min_lng', 'max_lng', 'min_lat', 'max_lat'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'entity_id' => 'Entity ID',
            'area_admin_id' => '此区块的管理员id',
            'registered_at' => 'Registered At',
            'city' => '城市ID',
            'district' => 'District',
            'area_name' => 'Area Name',
            'area_address' => 'Area Address',
            'polygon' => '区块的多边形序列',
            'min_lng' => 'Min Lng',
            'max_lng' => 'Max Lng',
            'min_lat' => 'Min Lat',
            'max_lat' => 'Max Lat',
        ];
    }
}
