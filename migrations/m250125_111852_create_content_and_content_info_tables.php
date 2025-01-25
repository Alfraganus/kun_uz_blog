<?php

use yii\db\Migration;

/**
 * Class m250125_111852_create_content_and_content_info_tables
 */
class m250125_111852_create_content_and_content_info_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('content', [
            'id' => $this->primaryKey(),
            'type' => $this->string()->defaultValue('blog'),
            'status' => $this->integer()->defaultValue(10),
            'is_deleted' => $this->integer()->defaultValue(false),
            'cacheable' => $this->boolean()->defaultValue(false),
            'author_id' => $this->integer()->null(),
            'created_on' => $this->string()->null(),
            'created_by' => $this->integer()->null(),
            'updated_on' => $this->string()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        $this->createTable('content_info', [
            'id' => $this->primaryKey(),
            'content_id' => $this->integer()->notNull(),
            'language' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'slug' => $this->string()->null(),
            'description' => $this->text(),
            'content' => $this->text(),
            'content_blocks' => $this->json(),
            'meta' => $this->json(),
        ]);

        $this->addForeignKey(
            'fk_content_author_id',
            'content',
            'author_id',
            'user',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_content_updated_by',
            'content',
            'updated_by',
            'user',
            'id',
            'SET NULL',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_content_created_by',
            'content',
            'created_by',
            'user',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_content_info_content_id',
            'content_info',
            'content_id',
            'content',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_content_info_content_id', 'content_info');
        $this->dropTable('content_info');

        $this->dropTable('content');
    }
}
