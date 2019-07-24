<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article}}`.
 */
class m190414_023023_create_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%article}}', [
            'id'          => $this->primaryKey(),
            'title'       => $this->string(),
            'content'     => $this->text(),
            'date'        => $this->dateTime()->defaultValue(null),
            'image'       => $this->string('36'),
            'user_id'     => $this->integer(),
            'status'      => $this->integer('1'),
            'category_id' => $this->integer('1'),
        ]);
        $this->createIndex(
            'date',
            'article',
            'date'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%article}}');
    }
}
