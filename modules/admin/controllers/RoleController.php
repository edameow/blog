<?php

namespace app\modules\admin\controllers;

use app\models\Moderator;
use app\models\RoleForm;
use Yii;
use app\models\User;
use yii\web\Controller;

/**
 * ModeratorController implements the CRUD actions for User model.
 */
class RoleController extends Controller
{
    public function actionModerator()
    {
        $model = new RoleForm();

        $user = $this->getUser('moderator');

        if ($model->load(Yii::$app->request->post())) {
            $this->setRole($model, 'moderator');
            return $this->refresh();
        }

        return $this->render('moderator', [
            'model' => $model,
            'user' => $user,
        ]);
    }

    public function actionAdmin()
    {
        $model = new RoleForm();

        $user = $this->getUser('admin');

        if ($model->load(Yii::$app->request->post())) {
            $this->setRole($model, 'admin');
            return $this->refresh();
        }

        return $this->render('admin', [
            'model' => $model,
            'user' => $user,
        ]);
    }

    public function actionContentmaker()
    {
        $model = new RoleForm();

        $user = $this->getUser('contentmaker');

        if ($model->load(Yii::$app->request->post())) {
            $this->setRole($model, 'contentmaker');
            return $this->refresh();
        }

        return $this->render('contentmaker', [
            'model' => $model,
            'user' => $user,
        ]);
    }

    public function actionDelete($id, $role)
    {
        $model = new RoleForm();
        $model->removeRole($id, $role);

        return $this->goBack($role);
    }

    protected function getUser($role)
    {
        $user = User::find()->where([$role => 1])->all();
        return $user;
    }

    protected function setRole($model, $role)
    {
        $id = $this->getId();
        $model->setRole($id, $role);
    }

    protected function getId()
    {
        $id = Yii::$app->request->post('RoleForm');
        $id = $id['id'];
        return $id;
    }
}
