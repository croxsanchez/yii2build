<?php

namespace backend\models\customer;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use common\models\User;
use backend\models\customer\CustomerRecord;
use backend\models\customer\DomainStatusRecord;
use backend\models\PaymentStatus;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "domain".
 *
 * @property integer $id
 * @property string $name
 * @property integer $customer_id
 * @property integer $domain_status_value
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property Customer $customer
 * @property User $createdBy
 * @property User $updatedBy
 * @property Website[] $websites
 */
class Domain extends \yii\db\ActiveRecord
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
            [['name', 'customer_id'], 'required'],
            [['customer_id', 'domain_status_value', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerRecord::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
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
            'customer_id' => 'Customer ID',
            'customerName' => 'Full Name',
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
    public function getWebsites()
    {
        return $this->hasMany(Website::className(), ['domain_id' => 'id']);
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
