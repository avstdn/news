<?php

use yii\db\Migration;

/**
 * Class m180510_215329_articles_image_path
 */
class m180510_215329_articles_image_path extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('articles', 'image_path', $this->string(128));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('articles', 'image_path');
    }

}
