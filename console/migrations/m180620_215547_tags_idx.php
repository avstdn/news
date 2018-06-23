<?php

use yii\db\Migration;

/**
 * Class m180620_215547_tags_idx
 */
class m180620_215547_tags_idx extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('atricles_tags__first_tag_id_fk', 'articles', 'first_tag', 'tags', 'id', 'CASCADE');
        $this->addForeignKey('atricles_tags__second_tag_id_fk', 'articles', 'second_tag', 'tags', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('atricles_tags__first_tag_id_fk', 'articles');
        $this->dropForeignKey('atricles_tags__second_tag_id_fk', 'articles');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180620_215547_tags_idx cannot be reverted.\n";

        return false;
    }
    */
}
