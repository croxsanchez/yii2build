<?php

namespace backend\models\customer;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use common\models\User;
use backend\models\customer\CustomerRecord;
use backend\models\customer\DomainChoiceRecord;
use backend\models\customer\DomainStatusRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "pre_domain".
 *
 * @property integer $id
 * @property string $name
 * @property integer $website_id
 * @property integer $customer_id
 * @property integer $domain_choice_value
 * @property integer $domain_status_value
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property Customer $customer
 * @property User $createdBy
 * @property User $updatedBy
 * @property Website $website
 */
class PreDomain extends \yii\db\ActiveRecord
{
    public $second_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_domain';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'website_id', 'customer_id', 'domain_choice_value'], 'required'],
            [['website_id', 'customer_id', 'domain_choice_value', 'domain_status_value', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'second_name'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerRecord::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['website_id'], 'exist', 'skipOnError' => true, 'targetClass' => Website::className(), 'targetAttribute' => ['website_id' => 'id']],
            [['domain_choice_value'], 'exist', 'skipOnError' => true, 'targetClass' => DomainChoiceRecord::className(), 'targetAttribute' => ['domain_choice_value' => 'value']],
            [['domain_choice_value'],'in', 'range'=>array_keys($this->getDomainChoiceList())],
            [['domain_status_value'], 'exist', 'skipOnError' => true, 'targetClass' => DomainStatusRecord::className(), 'targetAttribute' => ['domain_status_value' => 'value']],
            [['domain_status_value'],'in', 'range'=>array_keys($this->getDomainStatusList())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'website_id' => 'Website ID',
            'customer_id' => 'Customer ID',
            'customerName' => 'Full Name',
            'domainChoiceOrder' => Yii::t('app', 'Domain Name Preference'),
            'domain_choice_value' => 'Domain Choice Value',
            'domain_status_value' => 'Domain Status Value',
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
        return $this->hasOne(CustomerRecord::className(), ['id' => 'customer_id']);
    }

    /**
    * get domain choice name
    *
    */
    public function getCustomerName(){
        return $this->customer ? $this->customer->name : '- no name provided -';
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
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebsite()
    {
        return $this->hasOne(Website::className(), ['id' => 'website_id']);
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
    * get domain status
    *
    */
    public function getDomainStatus()
    {
         return $this->hasOne(DomainStatusRecord::className(), ['value' => 'domain_status_value']);
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
}



