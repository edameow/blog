<?php

namespace app\modules\admin\models;


use yii\base\Model;
use yii\web\NotFoundHttpException;

class RoleForm extends Model
{
    public $id;

    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Введите ID',
        ];
    }

    public function setRole($id, $role)
    {
        $user = $this->findUser($id);
        $user->$role = 1;
        return $user->save(false);
    }

    public function removeRole($id, $role)
    {
        $user = $this->findUser($id);
        $user->$role = 0;
        return $user->save(false);
    }

    private function findUser($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}