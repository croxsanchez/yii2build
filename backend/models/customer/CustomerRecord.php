<?php

namespace backend\models\customer;

use Yii;
use yii\db\ActiveRecord;
use backend\models\customer\CustomerType;
use backend\models\customer\PhoneRecord;
use backend\models\customer\EmailRecord;
use backend\models\customer\AddressRecord;
use yii\helpers\ArrayHelper;

class CustomerRecord extends ActiveRecord
{
    public static function tableName()
    {
        return 'customer';
    }

    public function rules()
    {
        return [
            ['id', 'number'],
            ['name', 'required'],
            ['name', 'string', 'max' => 256],
            ['birth_date', 'date', 'format' => 'Y-m-d'],
            ['notes', 'safe'],
            ['customer_type_id', 'number']
        ];
    }
    
    /* Your model attribute labels */
    public function attributeLabels(){
        return [
            /* Your other attribute labels */
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Full Name'),
            'birth_date' => Yii::t('app', 'Birth Date'),
            'notes' => Yii::t('app', 'Notes'),
            'customer_type_id' => Yii::t('app', 'Customer Type'),
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => \yii\behaviors\TimestampBehavior::className(),
            'blame' => \yii\behaviors\BlameableBehavior::className()
        ];
    }

    public function getPhones()
    {
        return $this->hasMany(PhoneRecord::className(), ['customer_id' => 'id']);
    }

    public function getAddresses()
    {
        return $this->hasMany(AddressRecord::className(), ['customer_id' => 'id']);
    }

    public function getEmails()
    {
        return $this->hasMany(EmailRecord::className(), ['customer_id' => 'id']);
    }
    
    public function getCustomerType()
    {
         return $this->hasOne(CustomerType::className(), ['customer_type_value' => 'customer_type_id']);
    }
    
    /**
    * get customer type name
    *
    */
    public function getCustomerTypeName(){
        return $this->customerType ? $this->customerType->customer_type_name : '- no user type -';
    }
    
    /**
    * get list of customer types for dropdown
    */
    public static function getCustomerTypeList(){
        $droptions = CustomerType::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'customer_type_value', 'customer_type_name');
    }
}
