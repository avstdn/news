<?php

use yii\db\Migration;

/**
 * Class m180621_125931_rules_terms
 */
class m180621_125931_rules_terms extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('rules', 'rule');
        $this->addColumn('rules', 'time', $this->string(32));
        $this->addColumn('rules', 'interest', $this->string(32));
        $this->addColumn('rules', 'significance', $this->string(64));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('rules', 'rule', $this->string(128));
        $this->dropColumn('rules', 'time');
        $this->dropColumn('rules', 'interest');
        $this->dropColumn('rules', 'significance');
    }
}
