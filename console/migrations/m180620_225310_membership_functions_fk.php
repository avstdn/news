<?php

use yii\db\Migration;

/**
 * Class m180620_225310_membership_functions_fk
 */
class m180620_225310_membership_functions_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('membership_functions_user__id_mf_time_id_fk', 'user', 'mf_time_id', 'membership_functions', 'id', 'CASCADE');
        $this->addForeignKey('membership_functions_user__id_mf_interest_id_fk', 'user', 'mf_interest_id', 'membership_functions', 'id', 'CASCADE');
        $this->addForeignKey('membership_functions_user__id_mf_significance_id_fk', 'user', 'mf_significance_id', 'membership_functions', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('membership_functions_user__id_mf_time_id_fk', 'user');
        $this->dropForeignKey('membership_functions_user__id_mf_interest_id_fk', 'user');
        $this->dropForeignKey('membership_functions_user__id_mf_significance_id_fk', 'user');
    }
}
