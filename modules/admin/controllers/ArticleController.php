<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\ArticleTag;
use app\modules\admin\models\Article;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = $this->findOfferedModel();
        return $this->render('index', compact('model'));
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $tags = ArticleTag::find()->where(['article_id' => $id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'tags' => $tags,
        ]);
    }


    public function actionPublish($id)
    {
        $model = $this->findModel($id);
        $model->publishArticle();
        return $this->redirect('index');
    }

    public function actionReject($id)
    {
        $model = $this->findModel($id);
        $model->rejectArticle();
        return $this->redirect('index');
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    private function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function findOfferedModel()
    {
        if (($model = Article::find()->where(['status' => 0])->all()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
