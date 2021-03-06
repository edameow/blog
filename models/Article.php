<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $date
 * @property string $image
 * @property int $viewed
 * @property int $user_id
 * @property int $status
 * @property int $category_id
 *
 * @property ArticleTag[] $articleTags
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['title', 'content'], 'string'],
            [['date'], 'date', 'format' => 'php:Y-m-d H:i:s'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'content' => 'Текст',
            'date' => 'Date',
            'image' => 'Image',
            'viewed' => 'Viewed',
            'user_id' => 'User ID',
            'status' => 'Status',
            'category_id' => 'Category ID',
        ];
    }

    public function saveImage($nameImage)
    {
        $this->image = $nameImage;
        return $this->save(false);
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    public function deleteImage()
    {
        $model = new ImageUpload();
        $model->deleteCurrentImage($this->image, 'articles');
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function saveCategoryID($id)
    {
        $this->category_id = $id;
        $this->save(false);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id']);
    }

    public function getImage()
    {
        return ($this->image) ? '/images/articles/' . $this->image : '';
    }

    public function deleteTags($id)
    {
        ArticleTag::deleteAll(['article_id' => $id]);
    }

    public function linkTags($tags)
    {
        if (is_array($tags)) {
            foreach ($tags as $tag_id) {
                $tag = Tag::findOne($tag_id);
                $this->link('tags', $tag);
            }
        }
    }

    public function saveDraft()
    {
        $this->user_id = Yii::$app->user->id;
        $this->status = 2;
        return $this->save();
    }

    public function offerArticle()
    {
        $this->user_id = Yii::$app->user->id;
        $this->status = 0;
        return $this->save();
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    public function createTags()
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

}
