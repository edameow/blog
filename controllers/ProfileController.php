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
use app\models\Comment;
use app\models\ImageUpload;
use app\models\Tag;
use app\models\UpdateProfileForm;
use app\models\User;
use Faker\Factory;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ProfileController extends Controller
{
    public $layout = 'profile';

//    public function actionFakerArticle()
//    {
//        $faker = Factory::create();
//
//        for ($i = 0; $i < 15; $i++) {
//            $testTag = $faker->word;
//            $modelTag = new Tag();
//            $modelTag->title = $testTag;
//            $modelTag->save();
//        }
//
//        for ($i = 0; $i < 5; $i++) {
//            $testCategory = $faker->word;
//            $modelCategory = new Category();
//            $modelCategory->title = $testCategory;
//            $modelCategory->save();
//        }
//
//        $tag = Tag::find()->all();
//        foreach ($tag as $item) {
//            $arrTag[] = $item->id;
//        }
//
//        $category = Category::find()->all();
//        foreach ($category as $item) {
//            $arrCat[] = $item->id;
//        }
//
//        $user = User::find()->all();
//        foreach ($user as $item) {
//            $arrUser[] = $item->id;
//        }
//
//        for ($i = 0; $i < 1000; $i++) {
//            $tagID = $faker->randomElements($arrTag, $faker->randomElement([1, 2, 3, 4]));
//            $article = new Article();
//            $article->title = $faker->realText(30);
//            $article->content = $faker->realText(1000);
//            $article->user_id = $arrUser;
//            $article->status = $faker->boolean(5) ? 2 : 1;
//            $article->category_id = $faker->randomElement($arrCat);
//            $article->save();
//
//            $article->linkTags($tagID);
//        }
//    }
//
//    public function actionFakerComment()
//    {
//        $faker = Factory::create();
//
//        $user = User::find()->all();
//        foreach ($user as $item) {
//            $arrUser[] = $item->id;
//        }
//
//        $article = Article::find()->all();
//        foreach ($article as $item) {
//            $arrArt[] = $item->id;
//        }
//
//        foreach ($arrArt as $item) {
//            $countComments = range(0, 50);
//
//            for ($i = 0; $i <= $faker->randomElement($countComments); $i++) {
//                $comment = new Comment();
//                $comment->text = $faker->realText(100);
//                $comment->user_id = $faker->randomElement($arrUser);
//                $comment->article_id = $item;
//                $comment->save();
//            }
//        }
//    }

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

            $this->updateProfile($model);

            return $this->render('update', [
                'model' => $model,
                'model_value' => $model_value,
            ]);
        } else return $this->render('error');
    }

    private function updateProfile($model)
    {
        if (Yii::$app->request->isPost) {
            $user_value = Yii::$app->request->post('UpdateProfileForm');
            if ($model->saveChanges($user_value)) {
                return $this->redirect(['view']);
            } else {
                Yii::$app->session->setFlash('error-password', 'Введён неверный пароль');
                return $this->refresh();
            }
        }
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
            $user_id = Yii::$app->user->id;
            $model = $this->findDraft($user_id);
            return $this->render('draft', compact('model'));
        } else return $this->render('error');
    }

    public function actionOfferArticle($id)
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->contentmaker) {
            $model = $this->findArticle($id);
            $model->offerArticle();
            die(' ');
        } else return $this->render('error');
    }

    public function actionDeleteArticle($id)
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->contentmaker) {
            $tags = $this->getTagsId($id);
            $this->findArticle($id)->delete();
            $this->checkUselessTags($tags);
            die(' ');
        } else return $this->render('error');
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

    private function setImage($imageModel, $model, $folder)
    {
        $file = UploadedFile::getInstance($imageModel, 'image');
        if ($file) {
            $model->saveImage($imageModel->uploadFile($file, $model->image, $folder));
        }
    }

    private function getTagsId($id)
    {
        $tags = $this->getTags($id);
        if ($tags) {
            $array = $this->getReadableArray($tags);
            return $array;
        }
    }

    private function getTags($id)
    {
        $tags = ArticleTag::find()->asArray()->select('tag_id')->where(['article_id' => $id])->all();
        return $tags;
    }

    private function getReadableArray($tags_array)
    {
        foreach ($tags_array as $k => $item) {
            foreach ($item as $v => $value) {
                $array[] = $value;
            }
        }
        return $array;
    }

    private function checkUselessTags($tags)
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

    private function getSameTags($tags)
    {
        $same_tags = ArticleTag::find()->asArray()->select(['tag_id'])->distinct()->where(['tag_id' => $tags])->all();
        return $same_tags;
    }

    private function deleteUselessTags($tags, $same_tags)
    {
        $uselessTags = array_diff($tags, $same_tags);
        Tag::deleteAll(['id' => $uselessTags]);
    }

    private function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function findDraft($user_id)
    {
        if (($model = Article::find()->where(['status' => 2, 'user_id' => $user_id])->all()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function findArticle($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function createCategoryArr()
    {
        return ArrayHelper::map(Category::find()->all(), 'id', 'title');
    }

    private function saveTagsAndCategory($model, $id)
    {
        if (Yii::$app->request->isPost) {
            $model->deleteTags($id);
            $tagID = $model->createTags();
            $model->linkTags($tagID);
            $this->selectCategory($model);
        }
    }

    private function selectCategory($model)
    {
        $catagory = Yii::$app->request->post('category');
        $model->saveCategoryID($catagory);
    }

    private function getCurrentTags($id)
    {
        $getTagsId = ArticleTag::find()->where(['article_id' => $id])->all();
        $arrTagsId = [];
        foreach ($getTagsId as $item) {
            $arrTagsId[] = $item->tag->title;
        }

        return $tags = implode(' ', $arrTagsId);
    }

}