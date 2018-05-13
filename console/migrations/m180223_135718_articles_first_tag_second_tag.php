<?php

use yii\db\Migration;

/**
 * Class m180223_135718_articles_first_tag_second_tag
 */
class m180223_135718_articles_first_tag_second_tag extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('articles', 'first_tag', $this->integer());
        $this->addColumn('articles', 'second_tag', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('articles', 'first_tag');
        $this->dropColumn('articles', 'second_tag');
    }
}
