<?php

use yii\db\Migration;

/**
 * Class m180620_225820_rules_fk
 */
class m180620_225820_rules_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('membership_functions', 'rule_id', $this->integer());
        $this->addForeignKey('membership_functions_rules__rule_id_id_fk', 'membership_functions', 'rule_id', 'rules', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('membership_functions', 'rule_id');
        $this->dropForeignKey('membership_functions_rules__rule_id_id_fk', 'membership_functions');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180620_225820_rules_fk cannot be reverted.\n";

        return false;
    }
    */
}
