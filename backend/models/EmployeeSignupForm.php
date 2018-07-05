<?php
namespace backend\models;

use backend\controllers\EmployeeController;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class EmployeeSignupForm extends Model
{
    public $userId;
    public $username;
    public $mobile;
    public $role;
    public $password;
    public $passwordRepeat;


    public function attributeLabels()
    {
        return [
            'username' => '员工姓名',
            'mobile' => '员工联系方式',
            'role' => '员工角色',
            'password' => '密码',
            'passwordRepeat' => '重复密码',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['mobile', 'required'],
//            ['mobile', 'unique', 'targetClass' => '\common\models\User', 'message' => '该手机号码已被注册'],
            ['mobile', 'match', 'pattern' => '/^1[3|4|5|8][0-9]\d{4,8}$/', 'message' => '无效的手机号码'],

            ['role', 'required'],
            ['role', 'in', 'range' => array_keys(EmployeeController::getAvailableRoles()), 'message' => '无效的角色'],

            ['password', 'required'],
            ['password', 'string', 'min' => 4],

            ['passwordRepeat', 'required'],
            ['passwordRepeat', 'string', 'min' => 4],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup($shopId)
    {
        if (!$this->validate()) {
            return null;
        }

        if (empty($this->userId)) {
            $user = new User();
        } else {
            $user = User::findOne($this->userId);
        }
        $user->username = $this->username;
        $user->mobile = $this->mobile;
        $user->setPassword($this->password);
        $user->shop_id = $shopId;
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $user->setRoles([$this->role]);

        if ($user->save()) {
            $auth = \Yii::$app->authManager;
            $auth->revokeAll($user->id);
            $role = $auth->getRole($this->role);
            $auth->assign($role, $user->id);
            return $user;
        }
        
        return null;
    }

    /**
     * @param $user User
     */
    public function fromUser($user) {
        $this->userId = $user->id;
        $this->mobile = $user->mobile;
        $this->username = $user->username;
        $auth = \Yii::$app->authManager;
        $roles = $auth->getRolesByUser($user->id);
        foreach ($roles as $role) {
            if ($role->name == 'dealer' || $role->name == 'dealerEmployee') {
                $this->role = $role->name;
            }
        }
    }
}
