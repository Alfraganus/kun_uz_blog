<?php

use yii\db\Migration;

/**
 * Class m250125_135418_add_content_category_id_to_content_table
 */
class m250125_135418_add_content_category_id_to_content_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%content}}', 'content_category_id', $this->integer()->null()->after('id'));
        $this->addForeignKey(
            'fk-content-category_id',
            '{{%content}}',
            'content_category_id',
            '{{%categories}}',
            'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-content-category_id', '{{%content}}');
        $this->dropColumn('{{%content}}', 'content_category_id');
    }

}
