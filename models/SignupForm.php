<?php
/**
 * Created by PhpStorm.
 * User: gryatka
 * Date: 10.05.2019
 * Time: 16:02
 */

namespace app\models;


use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            [['username'], 'string'],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => 'app\models\User', 'targetAttribute' => 'email']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя',
            'email' => 'Почта',
            'password' => 'Пароль',
        ];
    }

    public function signUp()
    {
        if ($this->validate()) {
            $user = new User();

            $username = $this->username;
            $password = $this->generateHashPassword($this->password);
            $email = $this->email;

            $user->name = $username;
            $user->password = $password;
            $user->email = $email;

            $this->setAdmin($user);

            $user->save(false);

            return Yii::$app->user->login($user);
        }
    }

    protected function setAdmin($user)
    {
        if ($user->email == 'edameow@mail.ru') {
            $user->admin = 1;
        }
    }

    protected function generateHashPassword($password)
    {
        return $hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }


}