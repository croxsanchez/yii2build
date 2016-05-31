<?php

namespace backend\models\customer;

use Yii;

/**
 * This is the model class for table "email".
 *
 * @property integer $id
 * @property string $purpose
 * @property string $address
 * @property integer $customer_id
 *
 * @property Customer $customer
 */
class EmailRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id'], 'required'],
            [['customer_id'], 'integer'],
            [['purpose', 'address'], 'string', 'max' => 255],
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
            'purpose' => 'Purpose',
            'address' => 'Address',
            'customer_id' => 'Customer ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(CustomerRecord::className(), ['id' => 'customer_id']);
    }
    
    public function getFullEmail()
    {
        return implode(', ',
        array_filter(
        $this->getAttributes(
                ['purpose', 'address'])));
    }
}
