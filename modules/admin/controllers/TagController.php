<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Tag;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TagController implements the CRUD actions for Tag model.
 */
class TagController extends Controller
{

    /**
     * Lists all Tag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $tag = Tag::find()->all();

        return $this->render('index', [
            'tag' => $tag,
        ]);
    }

    /**
     * Deletes an existing Tag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        die(' ');
    }

    /**
     * Finds the Tag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    private function findModel($id)
    {
        if (($model = Tag::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
