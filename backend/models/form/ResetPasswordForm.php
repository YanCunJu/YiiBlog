<?php
namespace backend\models\form;

use yii\base\Model;
use yii\base\InvalidParamException;
use backend\models\db\Admin;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $password_repeat;

    /**
     * @var \backend\models\db\Admin
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
//    public function __construct($token, $config = [])
//    {
//        if (empty($token) || !is_string($token)) {
//            throw new InvalidParamException('Password reset token cannot be blank.');
//        }
//        $this->_user = User::findByPasswordResetToken($token);
//        if (!$this->_user) {
//            throw new InvalidParamException('Wrong password reset token.');
//        }
//        parent::__construct($config);
//    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat','compare','compareAttribute'=>'password','message'=>'两次输入的密码不一致'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'password'=>'密码',
            'password_repeat'=>'重输密码'
            ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword($id)
    {
        $user = Admin::findOne($id);
        $user->password = '*';
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
