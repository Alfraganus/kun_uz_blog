<?php

use yii\db\Migration;

/**
 * Class m250126_191040_add_categories_for_content_types
 */
class m250126_191040_add_categories_for_content_types extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $categories = [
            'blog' => [
                'Texnologiya yangiliklari',
                'Sayohat va turizm',
                'Oila va munosabatlar',
                'Sog\'liqni saqlash',
                'Ijtimoiy media va blogerlik',
            ],
            'yangiliklar' => [
                'Dunyo yangiliklari',
                'O\'zbekiston yangiliklari',
                'Sport yangiliklari',
                'Madaniyat va san\'at',
                'Iqtisodiy yangiliklar',
            ],
            'shaxsiy' => [
                'Shaxsiy rivojlanish',
                'Motivatsiya va ilhom',
                'Yoshlar masalalari',
                'Sahifa va karerani rejalashtirish',
                'Psixologiya va o\'zini tahlil qilish',
            ],
        ];

        foreach ($categories as $type => $categoryNames) {
            foreach ($categoryNames as $categoryName) {
                $this->insert('categories', [
                    'category_name' => $categoryName,
                    'category_type' => $type,
                ]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250126_191040_add_categories_for_content_types cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250126_191040_add_categories_for_content_types cannot be reverted.\n";

        return false;
    }
    */
}
