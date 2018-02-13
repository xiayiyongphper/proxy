<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "device_config".
 *
 * @property integer $id
 * @property string $title
 * @property string $device_id
 * @property string $charles
 * @property string $environment
 * @property integer $is_capture
 */
class DeviceConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'device_config';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('proxyDb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_capture'], 'integer'],
            [['title', 'device_id'], 'string', 'max' => 100],
            [['charles', 'environment'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '名称',
            'device_id' => '设备ID',
            'charles' => '代理地址(你的电脑ip)',
            'environment' => '需要测试的环境',
            'is_capture' => '是否抓包',
        ];
    }

    public static function getOptionArray(){
        $devices = self::find()->all();
        $ret = [];
        //$ret = $devices;
        foreach ($devices as $item) {
            $ret[$item->device_id] = $item->title."({$item->environment})";
        }
        return $ret;
    }
}
