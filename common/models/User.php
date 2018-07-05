<?php
namespace common\models;

use backend\models\DealerShop;
use Yii;
use yii\base\NotSupportedException;
use yii\web\NotFoundHttpException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $mobile
 * @property string $auth_key
 * @property integer $status
 * @property integer $customer_id
 * @property string $available_bonus
 * @property string $total_bonus
 * @property string $bankaccount
 * @property string $bankname
 * @property string $beneficiary
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $shop_id
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_NO_SMS = 11;

    const OBO_KEY = 'org_user_id';

//     const ROLES_NEED_SHOP = ['dealer', 'dealerEmployee'];

    private $_roles;
    
    public static function getRolesNeedShop()
    {
        return ['dealer', 'dealerEmployee'];
    }
    
    public function getRoles()
    {
        return $this->_roles;
    }
    
    public function setRoles($roles)
    {
        $this->_roles = $roles;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
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
    public function attributeLabels()
    {
        return [
            'username' => '姓名',
            'mobile' => '手机号码',
            'status' => '状态',
            'roles' => '角色',
            'shop_id' => '门店',
            'bankaccount' => '银行账号',
            'available_bonus' => '可用收益',
            'total_bonus' => '历史总收益',
            'bankaccount' => '收取提成收益的银行账号',
            'bankname' => '收取提成收益的银行名称',
            'beneficiary' => '收取提成收益的受益人',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_NO_SMS],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_NO_SMS]],
            ['mobile', 'string', 'max' => 11],
            ['mobile', 'match', 'pattern' => '/^1[3|4|5|8][0-9]\d{4,8}$/', 'message' => '无效的手机号码'],
            ['mobile', 'unique', 'targetClass' => '\common\models\User', 'message' => '该手机号码已被注册'],
            ['email', 'filter', 'filter' => 'trim'],
            [['mobile', 'username'], 'required'],
            ['email', 'email'],
            [['shop_id'], 'validateShopId', 'skipOnEmpty' => false, 'skipOnError' => false],
            ['email', 'string', 'max' => 255],
//          ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => '该Email已被注册'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['bankaccount', 'string', 'max' => 30],
            ['roles', 'safe'],
            [['customer_id'], 'integer'],
            [['available_bonus', 'total_bonus'], 'number'],
            [['available_bonus', 'total_bonus'], 'default', 'value' => 0],

        ];
    }

    public function validateShopId($attribute, $params, $validator)
    {
        if (!$this->hasErrors()) {
            if ($this->isNeedShop()) {
                if (empty($this->shop_id)) {
                    $this->addError($attribute, '门店不能为空。');
                }
            } else {
                $this->shop_id = null;
            }
        }
    }

    public function isNeedShop()
    {
        $needShop = false;
        if($this->_roles != null) {
            foreach ($this->_roles as $role) {
                if (in_array($role, self::getRolesNeedShop())) {
                    $needShop = true;
                    break;
                }
            }
        }
        return $needShop;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
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
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
    
    /**
     * Finds user by mobile
     *
     * @param string $mobile
     * @return static|null
     */
    public static function findByMobile($mobile)
    {
        return static::findOne(['mobile' => $mobile, 'status' => self::STATUS_ACTIVE]);
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

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
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
    
    /**
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_DELETED => '禁用',
            self::STATUS_ACTIVE => '正常',
            self::STATUS_NO_SMS => '注册短信未发送',
        ];
    }
    
    /**
     * @return string
     */
    public function getStatusLabel()
    {
        return self::getStatusList()[$this->status];
    }
    
    public static function getAllRoles() 
    {
        $roles = Yii::$app->authManager->getRoles();
        return ArrayHelper::map($roles, 'name', 'description');
    }
    
    public static function getAllUserList()
    {
        $users = self::find()->all();
        return ArrayHelper::map($users, 'id', 'username');
    }
    
    public static function getAllSalesman()
    {
        $userIds = Yii::$app->authManager->getUserIdsByRole('salesman');
        $users = self::find()->where(['in', 'id', $userIds])->all();
        return ArrayHelper::map($users, 'id', 'username');
    }
    
    public static function getAllCoreMember()
    {
        $userIds = Yii::$app->authManager->getUserIdsByRole('coreMember');
        $users = self::find()->where(['in', 'id', $userIds])->all();
        return ArrayHelper::map($users, 'id', 'username');
    }
    
    /**
     * send reg sms to specific user.
     * If the sms had been sent already, this method will do nothing and just return true.
     * @param integer $id the user who need to send reg sms
     * @return boolean whether do the reg sms send succussful
     */
    public static function sendRegSms($id)
    {
    	$model = static::findOne($id);
    	if ($model == null) {
    		throw new NotFoundHttpException('用户不存在.');
    	}
    	if($model->status != User::STATUS_NO_SMS) {
    		return true;
    	} else {
    		$password = static::getRandPassword();
    		$model->password = $password;
    		if (YII_DEBUG) {
                $model->password = '123456';
    			Yii::$app->session->addFlash('success', '新用户密码是' .  $password);
    			$ret = true;
    		} else {
    			$ret = Yii::$app->sms->sendRegSms($model->mobile, $password);
    		}
    		if($ret) {
    			$model->status = User::STATUS_ACTIVE;
    		}
    		$model->save(false);
    		return $ret;
    	}
    }
    
    /**
     * generate a rand init password that have 6 chars
     * @return string the password
     */
    private static function getRandPassword() {
        $str = '';
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen ( $strPol ) - 1;
    
        for($i = 0; $i < 6; $i ++) {
            $str .= $strPol [rand ( 0, $max )];
        }
    
        return $str;
    }

    public function getShop()
    {
        return $this->hasOne(DealerShop::className(), ['id' => 'shop_id']);
    }

    public static function isObo()
    {
        $id = Yii::$app->session->get(self::OBO_KEY);
        return $id != null;
    }

}
