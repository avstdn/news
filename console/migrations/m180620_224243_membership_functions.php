<?php

use yii\db\Migration;

/**
 * Class m180620_224243_membership_functions
 */
class m180620_224243_membership_functions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('membership_functions', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64),
            'coords' => $this->string(128),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'user_id' => $this->integer(),
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('membership_functions');
    }
}
