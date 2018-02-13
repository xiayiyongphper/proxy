<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "fake_port_map".
 *
 * @property integer $id
 * @property string $fake_port
 * @property string $module
 * @property string $ip
 * @property string $port
 */
class FakePortMap extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fake_port_map';
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
            [['fake_port', 'module', 'ip', 'port'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fake_port' => 'Fake Port',
            'module' => 'Module',
            'ip' => 'Ip',
            'port' => 'Port',
        ];
    }
}
