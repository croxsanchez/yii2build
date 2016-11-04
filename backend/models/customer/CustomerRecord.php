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
use common\models\User;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $name
 * @property string $birth_date
 * @property string $notes
 * @property integer $customer_type_id
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property boolean $online_store
 * @property boolean $social_media
 * @property string $id_card_number
 *
 * @property Address[] $addresses
 * @property User $createdBy
 * @property User $updatedBy
 * @property Domain[] $domains
 * @property Email[] $emails
 * @property Phone[] $phones
 */
class CustomerRecord extends ActiveRecord
{
    public $ident_card_number;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            [['birth_date', 'created_at', 'updated_at'], 'safe'],
            [['notes', 'online_store', 'social_media'], 'safe'],
            [['notes'], 'string'],
            [['customer_type_id', 'created_by', 'updated_by'], 'integer'],
            [['online_store', 'social_media'], 'boolean'],
            [['name'], 'string', 'max' => 255],
            ['birth_date', 'date', 'format' => 'Y-m-d'],
            [['id_card_number'], 'string', 'max' => 40],
            [['customer_type_id', 'id_card_number'], 'required', 'on' => 'create'],
            [['customer_type_id', 'id_card_number'], 'unique', 'targetAttribute' => ['customer_type_id', 'id_card_number'], 'message' => 'The combination of Customer Type ID and Id Card Number has already been taken.'],
            [['customer_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerType::className(), 'targetAttribute' => ['customer_type_id' => 'customer_type_value']],
            [['customer_type_id'],'in', 'range'=>array_keys($this->getCustomerTypeList())],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
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
            'id_card_number' => 'Id Card Number',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
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
