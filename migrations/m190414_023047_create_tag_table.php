<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tag}}`.
 */
class m190414_023047_create_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%tag}}', [
            'id'    => $this->primaryKey(),
            'title' => $this->string('32')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%tag}}');
    }
}
