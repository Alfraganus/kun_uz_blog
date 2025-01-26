<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%media}}`.
 */
class m250126_125953_create_media_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('media', [
            'id' => $this->primaryKey(),
            'file_name' => $this->string()->notNull(),
            'file_url' => $this->string()->notNull(),
            'model_class'=> $this->string()->null(),
            'object_id'=> $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%media}}');
    }
}
