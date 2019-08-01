<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_black_list}}`.
 */
class m190731_125727_create_user_black_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_black_list}}', [
            'id'              => $this->primaryKey(),
            'user_id'         => $this->integer(),
            'black_list_user' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-user_user_black_list',
            'user_black_list',
            'user_id'
        );

        $this->addForeignKey(
            'fk-bl-user_user_black_list',
            'user_black_list',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-tag_user_black_list',
            'user_black_list',
            'black_list_user'
        );

        $this->addForeignKey(
            'fk-bl-tag_user_black_list',
            'user_black_list',
            'black_list_user',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_black_list}}');
    }
}
