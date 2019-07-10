<?php
/**
 * Created by PhpStorm.
 * User: gryatka
 * Date: 23.06.2019
 * Time: 15:47
 */

namespace app\models;


use Yii;
use yii\base\Model;

class UpdateProfileForm extends Model
{
    public $name;
    public $email;
    public $description;
    public $password;

    public function getValue()
    {
        $value = [
            $name = $this->getUser()->name,
            $email = $this->getUser()->email,
            $description = $this->getUser()->description,
        ];
        $keys = ['name', 'email', 'description'];

        $array = array_combine($keys, $value);

        return $array;
    }

    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required'],
            [['password'], 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name'        => 'Имя',
            'email'       => 'Почта',
            'description' => 'Описание',
            'password'    => 'Пароль',
        ];
    }

    public function saveChanges($user_value)
    {
        $user = $this->getUser();
        if ($this->validatePassword($user, $user_value['password'])) {

            $user->name = $user_value['name'];
            $user->email = $user_value['email'];
            $user->description = $user_value['description'];

            return $user->save(false);
        }
    }

    private function validatePassword($user, $password)
    {
        return Yii::$app->security->validatePassword($password, $user->password);
    }

    private function getUser()
    {
        $user_id = Yii::$app->user->identity->getId();
        return User::find()->where(['id' => $user_id])->one();
    }

}