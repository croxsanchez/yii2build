<?php

namespace backend\models\customer;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use common\models\User;
use backend\models\customer\CustomerRecord;
use backend\models\customer\ThemeRecord;
use backend\models\customer\DomainChoiceRecord;
use backend\models\customer\DomainStatusRecord;
use backend\models\PaymentStatus;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "domain".
 *
 * @property integer $id
 * @property string $name
 * @property integer $customer_id
 * @property integer $domain_choice_value
 * @property integer $payment_status_value
 * @property integer $domain_status_value
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $domain_method_value
 * 
 * @property User $createdBy
 * @property Customer $customer
 * @property Theme $theme
 * @property User $updatedBy
 * @property DomainTheme[] $domainThemes
 */
class DomainRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'domain';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'customer_id', 'payment_status_value'], 'required'],
            [['customer_id', 'domain_choice_value', 'payment_status_value', 'domain_status_value'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['domain_choice_value'], 'exist', 'skipOnError' => true, 'targetClass' => DomainChoiceRecord::className(), 'targetAttribute' => ['domain_choice_value' => 'value']],
            [['domain_choice_value'],'in', 'range'=>array_keys($this->getDomainChoiceList())],
            [['payment_status_value'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentStatus::className(), 'targetAttribute' => ['payment_status_value' => 'value']],
            [['payment_status_value'],'in', 'range'=>array_keys($this->getPaymentStatusList())],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerRecord::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'name' => 'Name',
            'customer_id' => 'Customer Id',
            'customerName' => 'Full Name',
            'domainChoiceOrder' => Yii::t('app', 'Domain Name Preference'),
            'payment_status_value' => 'Payment Status',
            'domain_status_value' => 'Domain Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
    
    /**
    * behaviors
    */
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
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(CustomerRecord::className(), ['customer_id' => 'id']);
    }
    
    public function getFullDomain()
    {
        return implode(', ',
        array_filter(
        $this->getAttributes(
                ['domain_choice_value', 'name'])));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['updated_by' => 'id']);
    }

    /**
    * set domain choice value
    *
    */
    public function setDomainChoiceValue($value)
    {
         $this->domain_choice_value = $value;
    }
    
    /**
    * get domain choice
    *
    */
    public function getDomainChoice()
    {
         return $this->hasOne(DomainChoiceRecord::className(), ['value' => 'domain_choice_value']);
    }
    
    /**
    * get domain choice name
    *
    */
    public function getDomainChoiceOrder(){
        return $this->domainChoice ? $this->domainChoice->order : '- no domain choice -';
    }
    
    /**
    * get list of domain choices for dropdown
    */
    public static function getDomainChoiceList(){
        $droptions = DomainChoiceRecord::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'value', 'order');
    }
    
    /**
    * set domain status value
    *
    */
    public function setDomainStatusValue($value)
    {
         $this->domain_status_value = $value;
    }
    
    /**
    * get domain status
    *
    */
    public function getDomainStatus()
    {
         return $this->hasOne(DomainStatusRecord::className(), ['domain_status_value' => 'value']);
    }
    
    /**
    * get domain choice name
    *
    */
    public function getDomainStatusName(){
        return $this->domainStatus ? $this->domainStatus->name : '- no domain status -';
    }
    
    /**
    * get list of domain choices for dropdown
    */
    public static function getDomainStatusList(){
        $droptions = DomainStatusRecord::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'value', 'name');
    }
    
    /**
    * set payment status value
    *
    */
    public function setPaymentStatusValue($value)
    {
         $this->payment_status_value = $value;
    }
    
    /**
    * get payment status
    *
    */
    public function getPaymentStatus()
    {
         return $this->hasOne(PaymentStatus::className(), ['payment_status_value' => 'value']);
    }
    
    /**
    * get payment status name
    *
    */
    public function getPaymentStatusName(){
        return $this->paymentStatus ? $this->paymentStatus->name : '- no payment status -';
    }
    
    /**
    * get list of payment statuses for dropdown
    */
    public static function getPaymentStatusList(){
        $droptions = PaymentStatus::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'value', 'name');
    }
}
