<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_black_list".
 *
 * @property int $id
 * @property int $user_id
 * @property int $black_list_user
 *
 * @property User $user
 * @property User $blackListUser
 */
class UserBlackList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_black_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'black_list_user'], 'default', 'value' => null],
            [['user_id', 'black_list_user'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['black_list_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['black_list_user' => 'id']],
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
            'black_list_user' => 'Black List User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlackListUser()
    {
        return $this->hasOne(User::className(), ['id' => 'black_list_user']);
    }

    public function banUser($id, $user_id)
    {
        $this->user_id = $user_id;
        $this->black_list_user = $id;
        $this->save();
    }
}
