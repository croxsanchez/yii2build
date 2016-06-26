<?php

namespace backend\models\customer;

use Yii;
use backend\models\customer\CustomerRecord;

/**
 * This is the model class for table "identification_card".
 *
 * @property integer $id
 * @property string $number
 * @property integer $customer_id
 * @property integer $identification_card_type_value
 *
 * @property Customer $customer
 */
class IdentificationCardRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'identification_card';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'customer_id'], 'required'],
            [['customer_id', 'identification_card_type_value'], 'integer'],
            [['number'], 'string', 'max' => 255],
            [['number'], 'unique'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerRecord::className(), 'targetAttribute' => ['customer_id' => 'id']],
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
            'identification_card_type_value' => 'Identification Card Type Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(CustomerRecord::className(), ['id' => 'customer_id']);
    }
}
