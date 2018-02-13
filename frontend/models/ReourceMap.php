<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "reource_map".
 *
 * @property integer $id
 * @property string $environment
 * @property string $data
 */
class ReourceMap extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reource_map';
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
            [['data'], 'required'],
            [['data'], 'string'],
            [['environment'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'environment' => 'Environment',
            'data' => 'Data',
        ];
    }
}
