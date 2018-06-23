<?php

use yii\db\Migration;

/**
 * Class m180620_221046_rules
 */
class m180620_221046_rules extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('rules', [
            'id' => $this->primaryKey(),
            'rule' => $this->string(128),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('rules');
    }
}
