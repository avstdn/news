<?php

namespace app\models;

/**
 * This is the model class for table "membership_functions".
 *
 * @property int $id
 * @property string $name
 * @property string $coords
 * @property string $created_at
 * @property string $updated_at
 * @property int $user_id
 * @property int $rule_id
 *
 * @property Rules $rule
 * @property User[] $users
 * @property User[] $users0
 * @property User[] $users1
 */
class MembershipFunctions extends \yii\db\ActiveRecord
{
    public $mf;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'membership_functions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'mf'], 'safe'],
            [['user_id', 'rule_id'], 'default', 'value' => null],
            [['user_id', 'rule_id'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['coords'], 'string'],
//            [['rule_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rules::className(), 'targetAttribute' => ['rule_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'coords' => 'Coords',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'user_id' => 'User ID',
            'rule_id' => 'Rule ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRule()
    {
        return $this->hasOne(Rules::className(), ['id' => 'rule_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['mf_time_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers0()
    {
        return $this->hasMany(User::className(), ['mf_interest_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers1()
    {
        return $this->hasMany(User::className(), ['mf_significance_id' => 'id']);
    }
}