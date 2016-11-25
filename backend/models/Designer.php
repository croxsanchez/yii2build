<?php

namespace backend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "designer".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $id_card_number
 *
 * @property User $user
 */
class Designer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'designer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'first_name', 'last_name', 'id_card_number'], 'required'],
            [['user_id'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 45],
            [['id_card_number'], 'string', 'max' => 40],
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
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'id_card_number' => 'Id Card Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getFullName()
    {
        return implode(', ',
            array_filter(
                $this->getAttributes(
                        ['first_name', 'last_name']
                )
            )
        );
    }
}
