<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "unknown_device".
 *
 * @property integer $id
 * @property string $device_id
 * @property string $created_at
 */
class UnknownDevice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unknown_device';
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
            [['created_at'], 'safe'],
            [['device_id'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'device_id' => 'Device ID',
            'created_at' => 'Created At',
        ];
    }
}
