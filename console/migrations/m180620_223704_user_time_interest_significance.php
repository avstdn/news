<?php

use yii\db\Migration;

/**
 * Class m180620_223704_user_time_interest_significance
 */
class m180620_223704_user_time_interest_significance extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'mf_time_id', $this->integer());
        $this->addColumn('user', 'mf_interest_id', $this->integer());
        $this->addColumn('user', 'mf_significance_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'mf_time_id');
        $this->dropColumn('user', 'mf_interest_id');
        $this->dropColumn('user', 'mf_significance_id');
    }
}
