<?php

namespace backend\models\customer;

use Yii;
use yii\db\ActiveRecord;
use backend\models\customer\ThemeRecord;
use backend\models\customer\DomainThemeRecord;
use backend\models\customer\PreDomain;
use backend\models\customer\Domain;
use common\models\User;
use backend\models\customer\CustomerRecord;
use yii\helpers\ArrayHelper;
use backend\models\PaymentMethod;
use backend\models\PaymentStatus;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "website".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property string $description
 * @property integer $theme_id
 * @property integer $payment_method_value
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $payment_status_value
 * @property integer $domain_id
 * @property boolean $online_store
 * @property boolean $social_media
 *
 * @property DesignerWebsite $designerWebsite
 * @property Designer[] $designers
 * @property PreDomain[] $preDomains
 * @property Customer $customer
 * @property Domain $domain
 * @property Theme $theme
 * @property User $createdBy
 * @property User $updatedBy
 */
class Website extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'website';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'theme_id', 'payment_method_value'], 'required'],
            [['customer_id', 'theme_id', 'payment_method_value', 'created_by', 'updated_by', 'payment_status_value', 'domain_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['online_store', 'social_media'], 'boolean'],
            [['description'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerRecord::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['domain_id'], 'exist', 'skipOnError' => true, 'targetClass' => Domain::className(), 'targetAttribute' => ['domain_id' => 'id']],
            [['theme_id'], 'exist', 'skipOnError' => true, 'targetClass' => ThemeRecord::className(), 'targetAttribute' => ['theme_id' => 'id']],
            [['payment_method_value'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentMethod::className(), 'targetAttribute' => ['payment_method_value' => 'value']],
            [['payment_method_value'],'in', 'range'=>array_keys($this->getPaymentMethodList())],
            [['payment_status_value'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentStatus::className(), 'targetAttribute' => ['payment_status_value' => 'value']],
            [['payment_status_value'],'in', 'range'=>array_keys($this->getPaymentStatusList())],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'customerName' => 'Full Name',
            'description' => 'Description',
            'theme_id' => 'Theme ID',
            'payment_method_value' => 'Payment Method Value',
            'paymentMethodName' => Yii::t('app', 'Payment Method'),
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'payment_status_value' => Yii::t('app', 'Payment Status Value'),
            'paymentStatusName' => 'Payment Status',
            'domain_id' => 'Domain ID',
            'online_store' => 'Online Store',
            'social_media' => 'Social Media',
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
    public function getDesignerWebsite()
    {
        return $this->hasOne(DesignerWebsite::className(), ['website_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDesigners()
    {
        return $this->hasMany(Designer::className(), ['id' => 'designer_id'])->viaTable('designer_website', ['website_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreDomains()
    {
        return $this->hasMany(PreDomain::className(), ['website_id' => 'id']);
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

    public function getFullWebsite()
    {
        return implode(', ',
        array_filter(
        $this->getAttributes(
                ['description'])));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomain()
    {
        return $this->hasOne(Domain::className(), ['id' => 'domain_id']);
    }

    /**
     * get theme name
     *
     */
    public function getDomainName(){
        return $this->domain ? $this->domain->name : '- no theme -';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTheme()
    {
         return $this->hasOne(ThemeRecord::className(), ['id' => 'theme_id']);
    }

    /**
     * get theme name
     *
     */
    public function getThemeName(){
        return $this->theme ? $this->theme->name : '- no theme -';
    }

    /**
     * get list of domain choices for dropdown
     */
    public static function getThemeList(){
        $droptions = ThemeRecord::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'id', 'name');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomainThemes()
    {
        return $this->hasMany(DomainThemeRecord::className(), ['domain_id' => 'id']);
    }

    /**
     * get payment method
     *
     */
    public function getPaymentMethod()
    {
         return $this->hasOne(PaymentMethod::className(), ['value' => 'payment_method_value']);
    }

    /**
     * get payment method name
     *
     */
    public function getPaymentMethodName(){
        return $this->paymentMethod ? $this->paymentMethod->type : '- no payment method assigned -';
    }

    /**
     * get list of payment methods for dropdown
     */
    public static function getPaymentMethodList(){
        $droptions = PaymentMethod::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'value', 'type');
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
         return $this->hasOne(PaymentStatus::className(), ['value' => 'payment_status_value']);
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
}
