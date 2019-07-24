<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m190414_023104_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%user}}', [
            'id'           => $this->primaryKey(),
            'name'         => $this->string('32'),
            'email'        => $this->string()->defaultValue(null),
            'password'     => $this->string('60'),
            'image'        => $this->string('36')->defaultValue(null),
            'description'  => $this->string()->defaultValue(null),
            'admin'        => $this->integer('1')->defaultValue(0),
            'moderator'    => $this->integer('1')->defaultValue(0),
            'contentmaker' => $this->integer('1')->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
