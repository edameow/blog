<?php

namespace app\widgets\sidebar;


use app\models\Article;
use app\models\Category;
use app\models\Comment;
use yii\base\Widget;

class Sidebar extends Widget
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function run()
    {
        $popular = $this->getPopular();
        $latest = Article::find()->where(['status' => 1])->orderBy('date asc')->limit(4)->all();
        $category = Category::find()->all();

        return $this->render('sidebar', compact('popular', 'latest', 'category'));
    }

    private function getPopular()
    {
        $date = $this->dateAgo();
        $latest_article_id_array = $this->getLatestArticle($date);
        if ($latest_article_id_array) {
            $the_most_popular_articles = $this->getPopularArticle($latest_article_id_array);
            if ($the_most_popular_articles) {
                foreach ($the_most_popular_articles as $article) {
                    $popular_arr[] = Article::find()->where(['status' => 1, 'id' => $article])->all();
                }
                foreach ($popular_arr as $k => $item) {
                    foreach ($item as $v => $value) {
                        $popular[] = $value;
                    }
                } return $popular;
            } else return $popular = [];
        } else return $popular = [];
    }

    private function dateAgo()
    {
        $oneMonthAgo = time() - 60*60*24*7;
        $date = date('Y-m-d', $oneMonthAgo);
        return $date;
    }

    private function getLatestArticle($date)
    {
        $query = "SELECT id FROM article WHERE date > '$date' AND status = 1";
        $latest_article_id = Article::findBySql($query)->asArray()->all();
        if ($latest_article_id) {
            $latest_article_id_array = $this->getReadableArray($latest_article_id);
            return $latest_article_id_array;
        }
    }

    private function getPopularArticle($article_array)
    {
        $article_comment_array = $this->getArticleCommentArray($article_array);
        if ($article_comment_array) {
            $the_most_popular_articles = $this->theMostPopularArticles($article_comment_array);
            return $the_most_popular_articles;
        }
    }

    private function getArticleCommentArray($article_array)
    {
        $keys = [];
        $value = [];
        foreach ($article_array as $article_id) {
            $count_comment_id = Comment::find()->where(['article_id' => $article_id])->count();
            if ($count_comment_id) {
                $value[] = $count_comment_id;
                $keys[] = $article_id;
            }
        }
        $article_comment_array = array_combine($keys, $value);
        return $article_comment_array;
    }

    private function theMostPopularArticles($array)
    {
        arsort($array);
        $array = array_slice($array, 0, 3, true);
        foreach ($array as $k => $item) {
            $id_array[] = $k;
        }
        return $id_array;
    }

    private function getReadableArray($uselessArray)
    {
        foreach ($uselessArray as $k => $item) {
            foreach ($item as $v => $value) {
                $array[] = $value;
            }
        }
        return $array;
    }

}