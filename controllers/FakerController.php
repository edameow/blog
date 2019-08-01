<?php

namespace app\controllers;


use app\models\Article;
use app\models\Category;
use app\models\Comment;
use app\models\Tag;
use app\models\User;
use Faker\Factory;
use yii\web\Controller;

class FakerController extends Controller
{
//
//    Специально сделано всё в одном контроллере
//    Заполняет бд случайными статьями, категориями, тегами и комментариями
//
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionFakerTag()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 15; $i++) {
            $modelTag = new Tag();
            $modelTag->title = $faker->word;
            $modelTag->save();
        }

        echo "Удачно";
    }

    public function actionFakerCategory()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $modelCategory = new Category();
            $modelCategory->title = $faker->word;
            $modelCategory->save();
        }

        echo "Удачно";
    }

    public function actionFakerArticle()
    {
        $faker = Factory::create();

        $tag = Tag::find()->all();
        foreach ($tag as $item) {
            $arrTag[] = $item->id;
        }

        $category = Category::find()->all();
        foreach ($category as $item) {
            $arrCat[] = $item->id;
        }

        $user = User::find()->all();
        foreach ($user as $item) {
            $arrUser[] = $item->id;
        }

        for ($i = 0; $i < 1000; $i++) {
            $tagID = $faker->randomElements($arrTag, $faker->randomElement([1, 2, 3, 4]));
            $article = new Article();
            $article->title = $faker->realText(30);
            $article->content = $faker->realText(1000);
            $article->user_id = $faker->randomElement($arrUser);
            $article->status = $faker->boolean(5) ? 2 : 1;
            $article->category_id = $faker->randomElement($arrCat);

            if ($article->status == 1) {
                $article->date = date('Y-m-d H:i:s');
            }

            $article->save();

            $article->linkTags($tagID);
        }
        echo "Удачно";
    }

    public function actionFakerComment()
    {
        $faker = Factory::create();

        $user = User::find()->all();
        foreach ($user as $item) {
            $arrUser[] = $item->id;
        }

        $article = Article::find()->where(['status' => 1])->all();
        foreach ($article as $item) {
            $arrArt[] = $item->id;
        }

        foreach ($arrArt as $item) {
            $countComments = range(0, 50);

            for ($i = 0; $i <= $faker->randomElement($countComments); $i++) {
                $comment = new Comment();
                $comment->text = $faker->realText(100);
                $comment->user_id = $faker->randomElement($arrUser);
                $comment->article_id = $item;
                $comment->date = date('Y-m-d H:i:s');
                $comment->save();
            }
        }
        echo "Удачно";
    }
}