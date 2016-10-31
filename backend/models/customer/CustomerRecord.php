<?php

namespace backend\models\customer;

use Yii;
use yii\db\ActiveRecord;
use backend\models\customer\CustomerType;
use backend\models\customer\PhoneRecord;
use backend\models\customer\EmailRecord;
use backend\models\customer\AddressRecord;
use backend\models\IdentificationCardInitial;
use backend\models\IdentificationCardType;
use backend\models\customer\CustomerIdentificationCard;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;

class CustomerRecord extends ActiveRecord
{
    public $ident_card_id;
    public $ident_card_init_id;
    public $number; // Identification Card Number
    
    public static function tableName()
    {
        return 'customer';
    }

    public function rules()
    {
        return [
            ['id', 'number'],
            [['name', 'customer_type_id'], 'required'],
            ['customer_type_id', 'integer'],
            ['name', 'string', 'max' => 256],
            [['birth_date'], 'safe'],
            ['birth_date', 'date', 'format' => 'Y-m-d'],
            [['notes', 'online_store', 'social_media'], 'safe'],
            [['customer_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerType::className(), 'targetAttribute' => ['customer_type_id' => 'customer_type_value']],
            [['customer_type_id'],'in', 'range'=>array_keys($this->getCustomerTypeList())],
            [['ident_card_id', 'ident_card_init_id', 'number'], 'required', 'on' => 'create'],
            ['number', 'unique', 'targetClass' => '\backend\models\customer\CustomerIdentificationCard', 'message' => 'This id card number has already been taken.'],
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
            'customerTypeName' => Yii::t('app', 'Customer Type'),
            'online_store' => Yii::t('app', 'Online Store'),
            'social_media' => Yii::t('app', 'Social Media'),
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
            'blame' => [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_by', 'updated_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_by'],
                ]
            ]
        ];
    }
    
    /**
     * Signs user up.
     *
     * @return boolean
     */
    public function createIdentCardRecord()
    {
        if ($this->validate() && $this->save())
        {
            $customer_id_card = new CustomerIdentificationCard();
            $customer_id_card->number = $this->number;
            $customer_id_card->customer_id = $this->id;
            $customer_id_card->identification_card_initial_id = $this->ident_card_init_id;
            if ($customer_id_card->save()){
                return true;
            }
        }
        return  false;
    }

    public function getIdentification()
    {
        return $this->hasOne(CustomerIdentificationCard::className(), ['customer_id' => 'id']);
    }
    
    public function getDomains()
    {
        return $this->hasMany(DomainRecord::className(), ['customer_id' => 'id']);
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
