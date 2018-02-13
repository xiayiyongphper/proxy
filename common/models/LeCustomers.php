<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property string $username
 * @property integer $province
 * @property integer $city
 * @property integer $phone
 * @property integer $district
 * @property integer $area_id
 * @property string $address
 * @property string $detail_address
 * @property string $store_name
 * @property string $storekeeper
 * @property string $store_area
 * @property string $lat
 * @property string $lng
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_token
 * @property float $orders_total_price
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 */
class LeCustomers extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    public $auth_key;

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('customerDb');
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'le_customers';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'required'],
        ];
    }

    /**
     * get userinfo by entity_id and update userinfo in redis
     */
    public static function findIdentity($id)
    {
        $userinfo = static::findOne(['entity_id' => $id]);
        if ($userinfo) {
            //Yii::$app->redisCache->set('le_user_'.$userinfo->entity_id,$userinfo);
            Yii::$app->getSession()->set('le_user_' . $userinfo->entity_id, $userinfo);
        }
        return $userinfo;
    }


    /**
     * 更新session,redis,identity中保存的用户信息
     * @param $id
     * @return null|static
     */
    public static function getAndUpUserbyId($id)
    {
        $userInfo = static::findOne(['entity_id' => $id]);
        if ($userInfo) {
//        	Yii::$app->redisCache->set('le_user_'.$userinfo->entity_id,$userinfo);
            Yii::$app->getSession()->set('le_user_' . $userInfo->entity_id, $userInfo);
            Yii::$app->redisCache->set('le_user_'.$id,$userInfo);
            Yii::$app->user->identity = $userInfo;

        }
        return $userInfo;
    }

    /**
     * 变更绑定手机号
     * @param $phone
     * @param $id
     * @return null|static
     */
    public static function changeBandingPhone($id,$phone)
    {
        $userInfo = static::findOne(['entity_id' => $id]);
        if ($userInfo) {
            $userInfo->phone = $phone;
            $userInfo->save();
            self::getAndUpUserbyId($id);
            return true;
        }
        return false;
    }


    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @param string $password
     * @return static|null
     */
    public static function findByUsername($username, $password)
    {
        //手机号登陆或用户名登陆都可以
        return self::find()->where(['and',['username' => $username],['password' => $password]])
            ->orWhere(['and',['phone' => $username],['password' => $password]])->one();
    }

    /**
     * 通过userId得到超市模型
     * @param $customerId
     * @return null|static
     */
    public static function findByCustomerId($customerId)
    {
        return static::findOne(['entity_id' => $customerId]);
    }

    /**
     * Finds user by phone
     *
     * @param string $phone
     * @return static|null
     */
    public static function findByPhone($phone)
    {
        return static::findOne(['phone' => $phone]);
    }

    /**
     * 检查用户名是否存在
     * @param $username
     * @return null|static
     */
    public static function checkUserByUserName($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * 检查电话号码是否存在
     * @param $phone
     * @return null|static
     */
    public static function checkUserByPhone($phone)
    {

        return static::findOne(['phone' => $phone]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
