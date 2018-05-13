<?php

use yii\db\Migration;

/**
 * Class m180224_175100_articles_article
 */
class m180224_175100_articles_article extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('articles', 'article', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('articles', 'article');
    }
}
