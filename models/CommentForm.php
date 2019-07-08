<?php
/**
 * Created by PhpStorm.
 * User: gryatka
 * Date: 13.05.2019
 * Time: 18:40
 */

namespace app\models;


use Yii;
use yii\base\Model;

class CommentForm extends Model
{
    public $comment;

    public function rules()
    {
        return [
            [['comment'], 'string', 'length' => [3, 255]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'comment' => 'Комментарий',
        ];
    }

    public function saveComment($article_id)
    {
        $comment = new Comment();
        $comment->text = $this->comment;
        $comment->user_id = Yii::$app->user->id;
        $comment->article_id = $article_id;
        $comment->date = date('Y-m-d');
        return $comment->save();
    }
}