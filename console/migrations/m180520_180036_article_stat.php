<?php

use yii\db\Migration;

/**
 * Class m180520_180036_article_stat
 */
class m180520_180036_article_stat extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('article_stat', [
            'article_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'like' => $this->boolean()->defaultValue(false),
            'dislike' => $this->boolean()->defaultValue(false),
            'viewed' => $this->boolean()->defaultValue(false),
        ]);

        $this->addPrimaryKey('article_user_pk', 'article_stat', ['article_id', 'user_id']);
        $this->addForeignKey('article_user__article_id_fk', 'article_stat', 'article_id', 'articles', 'id', 'CASCADE');
        $this->addForeignKey('article_user__user_id_fk', 'article_stat', 'user_id', 'user', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('article_stat');
    }
}