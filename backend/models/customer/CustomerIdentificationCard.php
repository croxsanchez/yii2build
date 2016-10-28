<?php

namespace backend\models\customer;

use Yii;
use backend\models\IdentificationCardInitial;

/**
 * This is the model class for table "customer_identification_card".
 *
 * @property integer $id
 * @property string $number
 * @property integer $customer_id
 * @property integer $identification_card_initial_id
 *
 * @property IdentificationCardInitial $identificationCardInitial
 */
class CustomerIdentificationCard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer_identification_card';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'customer_id', 'identification_card_initial_id'], 'required'],
            [['customer_id', 'identification_card_initial_id'], 'integer'],
            [['number'], 'string', 'max' => 255],
            [['number'], 'unique'],
            [['identification_card_initial_id'], 'exist', 'skipOnError' => true, 'targetClass' => IdentificationCardInitial::className(), 'targetAttribute' => ['identification_card_initial_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'customer_id' => 'Customer ID',
            'identification_card_initial_id' => 'Identification Card Initial ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdentificationCardInitial()
    {
        return $this->hasOne(IdentificationCardInitial::className(), ['id' => 'identification_card_initial_id']);
    }
}
