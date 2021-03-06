<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property string $customer_id
 * @property string $device_id
 * @property string $route
 * @property string $client
 * @property string $api_remote
 * @property string $charles
 * @property string $proxy_show
 * @property string $request
 * @property integer $response_code
 * @property string $response
 * @property string $created_at
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
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
            [['request', 'response'], 'string'],
            [['created_at'], 'safe'],
			[['response_code'], 'integer'],
            [['customer_id', 'device_id'], 'string', 'max' => 100],
            [['route', 'client', 'api_remote', 'charles', 'proxy_show'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
			'customer_id' => 'Customer ID',
            'device_id' => 'Device ID',
            'route' => 'Route',
            'client' => 'Client',
            'api_remote' => 'Api Remote',
            'charles' => 'Charles',
            'proxy_show' => 'Proxy Show',
            'request' => 'Request',
			'response_code' => 'Response Code',
            'response' => 'Response',
            'created_at' => 'Created At',
        ];
    }
}
