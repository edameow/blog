<?php

namespace app\modules\admin\models;


/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $isAdmin
 * @property string $photo
 *
 * @property Comment[] $comments
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['admin'], 'integer'],
            [['name', 'email', 'password', 'image', 'description', 'moderator'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'admin' => 'Is Admin',
            'image' => 'Photo',
            'description' => 'Description',
            'moderator' => 'Moderator',
        ];
    }

}
