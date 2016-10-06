<?php

namespace backend\models\customer;

use Yii;

/**
 * This is the model class for table "seller".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $parent_id
 * @property integer $total_points
 * @property integer $rank_value
 * @property string $rank_date
 * @property integer $credits
 *
 * @property Points[] $points
 * @property User $user
 */
class Seller extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seller';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'parent_id', 'rank_date'], 'required'],
            [['user_id', 'parent_id', 'total_points', 'rank_value', 'credits'], 'integer'],
            [['rank_date'], 'safe'],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'parent_id' => 'Parent ID',
            'total_points' => 'Total Points',
            'rank_value' => 'Rank Value',
            'rank_date' => 'Rank Date',
            'credits' => 'Credits',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPoints()
    {
        return $this->hasMany(Points::className(), ['seller_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
