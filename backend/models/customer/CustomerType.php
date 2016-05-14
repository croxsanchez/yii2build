<?php

namespace backend\models\customer;

use Yii;
use backend\models\customer\Customer;

/**
 * This is the model class for table "user_type".
 *
 * @property integer $id
 * @property string $customer_type_name
 * @property integer $customer_type_value
 */
class CustomerType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_type_value'], 'required'],
            [['customer_type_value'], 'integer'],
            [['customer_type_name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_type_name' => 'Customer Type Name',
            'customer_type_value' => 'Customer Type Value',
        ];
    }
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCustomer(){
        return $this->hasMany(Customer::className(), ['customer_type_id' => 'customer_type_value']);
    }
}
