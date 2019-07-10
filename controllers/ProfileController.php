<?php
/**
 * Created by PhpStorm.
 * User: gryatka
 * Date: 15.05.2019
 * Time: 17:25
 */

namespace app\controllers;


use app\models\Article;
use app\models\ArticleTag;
use app\models\Category;
use app\models\ImageUpload;
use app\models\Tag;
use app\models\UpdateProfileForm;
use app\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ProfileController extends Controller
{
    public $layout = 'profile';

    public function actionView()
    {
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity;
            return $this->render('view', compact('user'));
        } else return $this->render('error');
    }

    public function actionUpdate()
    {
        if (!Yii::$app->user->isGuest) {
            $model = new UpdateProfileForm();
            $model_value = $model->getValue();

            if (Yii::$app->request->isPost) {
                $user_value = Yii::$app->request->post('UpdateProfileForm');
                if ($model->saveChanges($user_value)) {
                    return $this->redirect(['view']);
                }
            }

            return $this->render('update', [
                'model' => $model,
                'model_value' => $model_value,
            ]);
        } else return $this->render('error');
    }


    public function actionSetImage()
    {
        if (!Yii::$app->user->isGuest) {
            $id = Yii::$app->user->id;

            $model = new ImageUpload;

            if (Yii::$app->request->isPost) {
                $user = $this->findModel($id);
                $this->setImage($model, $user, 'avatar');
                return $this->redirect(['view']);
            }

            return $this->render('image', compact('model'));
        } else return $this->render('error');
    }

    public function actionCreate()
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->contentmaker) {
                $imageModel = new ImageUpload;
                $model = new Article();
                $categories = $this->createCategoryArr();

                if ($model->load(Yii::$app->request->post()) && $model->saveDraft()) {

                    $this->setImage($imageModel, $model, 'articles');

                    $id = $model->id;
                    $this->saveTagsAndCategory($model, $id);
                    return $this->redirect(['view']);
                }

                return $this->render('create', [
                    'model' => $model,
                    'categories' => $categories,
                    'imageModel' => $imageModel,
                ]);
        } else return $this->render('error');
    }

    public function actionDraft()
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->contentmaker) {
            $this->ajaxAction();
            $user_id = Yii::$app->user->id;
            $model = $this->findDraft($user_id);
            return $this->render('draft', compact('model'));
        } else return $this->render('error');
    }

    private function ajaxAction()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->get('id');
            $action = Yii::$app->request->get('action');
            $this->ajaxOfferAction($id, $action);
            $this->ajaxDeleteAction($id, $action);
            echo ' ';
            die();
        }
    }

    private function ajaxOfferAction($id, $action)
    {
        if ($action == 'offer') {
            $this->offerArticle($id);
        }
    }

    private function ajaxDeleteAction($id, $action)
    {
        if ($action == 'delete') {
            $this->deleteArticle($id);
        }
    }

    public function actionArticle($id)
    {
        $imageModel = new ImageUpload;
        $model = $this->findArticle($id);
        $categories = $this->createCategoryArr();
        $tags = $this->getCurrentTags($id);

        if ($model->user_id == Yii::$app->user->id && Yii::$app->user->identity->contentmaker) {
            if ($model->load(Yii::$app->request->post()) && $model->saveDraft()) {

                $this->setImage($imageModel, $model, 'articles');

                $this->saveTagsAndCategory($model, $id);
                return $this->redirect(['draft']);
            }

            return $this->render('article', [
                'model' => $model,
                'categories' => $categories,
                'tags' => $tags,
                'imageModel' => $imageModel,
            ]);
        } else return $this->render('error');
    }

//    public function actionArticleImage($id)
//    {
//        $model = new ImageUpload;
//
//        if (Yii::$app->request->isPost) {
//            $article = $this->findArticle($id);
//            $this->setImage($model, $article, 'articles');
//            return $this->redirect(['article', 'id' => $id]);
//        }
//
//        return $this->render('image', compact('model'));
//    }

    private function offerArticle($id)
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->contentmaker) {
            $model = $this->findArticle($id);
            $model->saveArticle();
        } else return $this->render('error');
    }

    private function deleteArticle($id)
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->contentmaker) {
            $tags = $this->getTagsId($id);
            $this->findArticle($id)->delete();
            $this->checkUselessTags($tags);

            return $this->redirect(['draft']);
        } else return $this->render('error');
    }

    protected function setImage($imageModel, $model, $folder)
    {
        $file = UploadedFile::getInstance($imageModel, 'image');
        if ($file) {
            $model->saveImage($imageModel->uploadFile($file, $model->image, $folder));
        }
    }

    protected function getTagsId($id)
    {
        $tags = $this->getTags($id);
        if ($tags) {
            $array = $this->getReadableArray($tags);
            return $array;
        }
    }

    protected function getTags($id)
    {
        $tags = ArticleTag::find()->asArray()->select('tag_id')->where(['article_id' => $id])->all();
        return $tags;
    }

    protected function getReadableArray($tags_array)
    {
        foreach ($tags_array as $k => $item) {
            foreach ($item as $v => $value) {
                $array[] = $value;
            }
        }
        return $array;
    }

    protected function checkUselessTags($tags)
    {
        if ($tags) {
            $same_tags = $this->getSameTags($tags);
            if ($same_tags) {
                $same_tags = $this->getReadableArray($same_tags);
                if (count($tags) != count($same_tags)) {
                    $this->deleteUselessTags($tags, $same_tags);
                }
            } else $this->deleteUselessTags($tags, $same_tags);
        }
    }

    protected function getSameTags($tags)
    {
        $same_tags = ArticleTag::find()->asArray()->select(['tag_id'])->distinct()->where(['tag_id' => $tags])->all();
        return $same_tags;
    }

    protected function deleteUselessTags($tags, $same_tags)
    {
        $uselessTags = array_diff($tags, $same_tags);
        Tag::deleteAll(['id' => $uselessTags]);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findDraft($user_id)
    {
        if (($model = Article::find()->where(['status' => 2, 'user_id' => $user_id])->all()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findArticle($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function createCategoryArr()
    {
        return ArrayHelper::map(Category::find()->all(), 'id', 'title');
    }

    protected function saveTagsAndCategory($model, $id)
    {
        if (Yii::$app->request->isPost) {
            $model->deleteTags($id);
            $tagID = $this->createTags();
            $model->linkTags($tagID);
            $this->selectCategory($model);
        }
    }

    protected function createTags()
    {
        $tagsValue = Yii::$app->request->post('tags');
        if ($tagsValue) {
            $tagsArr = explode(" ", $tagsValue);
            foreach ($tagsArr as $one) {
                $arr = ArrayHelper::map(Tag::find()->all(), 'id', 'title');
                if (!in_array($one, $arr, true)) {
                    $tags = new Tag();
                    $tags->saveTags($one);
                }
                $arr = ArrayHelper::map(Tag::find()->all(), 'id', 'title');
                $tagID[] = array_search($one, $arr);
            }
            return $tagID;
        }
    }

    protected function selectCategory($model)
    {
        $catagory = Yii::$app->request->post('category');
        $model->saveCategoryID($catagory);
    }

    protected function getCurrentTags($id)
    {
        $getTagsId = ArticleTag::find()->where(['article_id' => $id])->all();
        $arrTagsId = [];
        foreach ($getTagsId as $item) {
            $arrTagsId[] = $item->tag->title;
        }

        return $tags = implode(' ', $arrTagsId);
    }

}