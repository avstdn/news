<?php

use yii\db\Migration;

/**
 * Class m180216_230433_articles
 */
class m180216_230433_articles extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('articles', [
            'id' => $this->primaryKey(),
            'article_id' => $this->string(64),
            'title' => $this->text()->notNull(),
            'url' => $this->string(128)->notNull(),
            'language' => $this->string(32)->notNull(),
            'image_url' => $this->string(128),
            'image_type' => $this->string(32),
            'date' => $this->date()->notNull(),
            'category' => $this->string(64),
            'content' => $this->text(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('articles');
    }
}
