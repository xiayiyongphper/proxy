<?php

namespace common\models;

use common\components\push\AndroidjiGuang;
use common\components\push\IosAppStoreJiGuang;
use common\components\push\IosEnterpriseJiGuang;
use service\models\common\CustomerException;
use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "le_app_push_queue".
 *
 * @property integer $entity_id
 * @property string $token
 * @property integer $group_id
 * @property integer $channel
 * @property integer $platform
 * @property integer $value_id
 * @property string $params
 * @property string $checksum
 * @property string $message
 * @property integer $status
 * @property integer $priority
 * @property string $created_at
 * @property string $scheduled_at
 * @property string $send_at
 * @property integer $typequeue
 */
class LeAppPushQueue extends ActiveRecord
{

    const PLATFORM_CUSTOMER = 1;
    const PLATFORM_MERCHANT = 2;
    const STATUS_PENDING = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_FAILURE = 2;
    const STATUS_PROCESSING = 3;
    const CHANNEL_IOS_APPSTORE = 1;
    const CHANNEL_IOS_ENTERPRISE = 2;
    const CHANNEL_ANDROID = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'le_app_push_queue';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('mainDb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [[['token', 'channel', 'value_id', 'checksum'], 'required'], [['group_id', 'channel', 'platform', 'value_id', 'status', 'priority', 'typequeue'], 'integer'], [['params', 'message'], 'string'], [['created_at', 'scheduled_at', 'send_at'], 'safe'], [['token'], 'string', 'max' => 100], [['checksum'], 'string', 'max' => 32]];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ['entity_id' => 'Entity ID', 'token' => 'Token', 'group_id' => 'Group ID', 'channel' => 'Channel', 'platform' => 'Platform', 'value_id' => 'Value ID', 'params' => 'Params', 'checksum' => 'Checksum', 'message' => 'Message', 'status' => 'Status', 'priority' => 'Priority', 'created_at' => 'Created At', 'scheduled_at' => 'Scheduled At', 'send_at' => 'Send At', 'typequeue' => 'Typequeue',];
    }

    /**
     * Function: send
     * Author: Jason Y. Wang
     * 推送消息
     * @return $this
     */
    public function send()
    {
        if ($this->channel >= 100000 && $this->channel < 200000) {
            // ios_appstore   ios_enterprise   android
            $channel = self::CHANNEL_IOS_APPSTORE;
        } elseif ($this->channel >= 200000 && $this->channel < 300000) {
            $channel = self::CHANNEL_IOS_ENTERPRISE;
        } else {
            $channel = self::CHANNEL_ANDROID;
        }

        try {
            $queue = '';
            $mobilesys = '';
            //判断推送方式
            switch ($channel) {
                case self::CHANNEL_IOS_APPSTORE:
                    $mobilesys = 'ios';
                    $queue = new IosAppStoreJiGuang();
                    break;
                case self::CHANNEL_IOS_ENTERPRISE:
                    $mobilesys = 'ios';
                    $queue = new IosEnterpriseJiGuang();
                    break;
                case self::CHANNEL_ANDROID:
                    $mobilesys = 'android';
                    $queue = new AndroidjiGuang();
                    break;
                default:
                    break;
            }

            $params = unserialize($this->params);
            if (!$params) {
                throw new CustomerException('Invalid params', 2001);
            }

            //推送参数
            $data = array('user_id' => $this->token, 'title' => $params['title'], 'content' => $params['content'], 'scheme' => $params['scheme'], 'mobilesys' => $mobilesys, 'sendno' => $this->entity_id,);
            //推送
            $result = $queue->push($data);
            if ($result) {
                $this->status = self::STATUS_SUCCESS;
            }
        } catch (Exception $e) {
            $this->status = self::STATUS_FAILURE;
            $this->message = $e->getMessage();
        }

        $this->send_at = date('Y-m-d H:i:s');
        return $this;
    }
}
