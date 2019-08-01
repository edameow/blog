<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tag_black_list".
 *
 * @property int $id
 * @property int $user_id
 * @property int $black_list_tag
 *
 * @property Tag $blackListTag
 * @property User $user
 */
class TagBlackList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag_black_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'black_list_tag'], 'default', 'value' => null],
            [['user_id', 'black_list_tag'], 'integer'],
            [['black_list_tag'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['black_list_tag' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'black_list_tag' => 'Black List Tag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlackListTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'black_list_tag']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function banTag($id, $user_id)
    {
        $this->user_id = $user_id;
        $this->black_list_tag = $id;
        $this->save();
    }
}
