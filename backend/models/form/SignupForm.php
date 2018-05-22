<?php
namespace backend\models\form;

use yii\base\Model;
use backend\models\db\Admin;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $status;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\backend\models\db\Admin', 'message' => '用户名已经存在'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\backend\models\db\Admin', 'message' => '邮箱已经存在'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat','compare','compareAttribute'=>'password','message'=>'两次输入的密码不一致'],
            ['status', 'in', 'range' => [0,1]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password'=>'密码',
            'password_repeat'=>'重输密码',
            'email' => 'Email',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new Admin();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->password = '*';
        $user->setPassword($this->password);
        $user->created_at = time();
        $user->updated_at = time();
        $user->status = 1;
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }

}
