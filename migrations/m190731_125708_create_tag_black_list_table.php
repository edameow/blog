<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tag_black_list}}`.
 */
class m190731_125708_create_tag_black_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tag_black_list}}', [
            'user_id'        => $this->integer(),
            'black_list_tag' => $this->integer(),
            'PRIMARY KEY(user_id, black_list_tag)',
        ]);

        $this->createIndex(
            'idx-user_tag_black_list',
            'tag_black_list',
            'user_id'
        );

        $this->addForeignKey(
            'fk-bl-user_tag_black_list',
            'tag_black_list',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-tag_tag_black_list',
            'tag_black_list',
            'black_list_tag'
        );

        $this->addForeignKey(
            'fk-bl-tag_tag_black_list',
            'tag_black_list',
            'black_list_tag',
            'tag',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tag_black_list}}');
    }
}
