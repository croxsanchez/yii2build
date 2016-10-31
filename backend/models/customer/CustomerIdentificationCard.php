<?php

namespace backend\models\customer;

use Yii;
use backend\models\IdentificationCardInitial;
use backend\models\IdentificationCardType;
use backend\models\customer\CustomerType;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "customer_identification_card".
 *
 * @property integer $id
 * @property string $number
 * @property integer $customer_id
 * @property integer $identification_card_initial_id
 *
 * @property IdentificationCardInitial $identificationCardInitial
 */
class CustomerIdentificationCard extends \yii\db\ActiveRecord
{
    public $card_type;
    public $card_initial;
    public $customer_type;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer_identification_card';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'customer_id', 'identification_card_initial_id'], 'required'],
            [['customer_id', 'identification_card_initial_id'], 'integer'],
            [['number'], 'string', 'max' => 255],
            [['number'], 'unique'],
            [['identification_card_initial_id'], 'exist', 'skipOnError' => true, 'targetClass' => IdentificationCardInitial::className(), 'targetAttribute' => ['identification_card_initial_id' => 'id']],
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
            'identification_card_initial_id' => 'Identification Card Initial ID',
            'card_type' => 'Document Type',
            'card_initial' => 'Document Initial',
            'customer_type' => 'Customer Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdentificationCardInitial()
    {
        return $this->hasOne(IdentificationCardInitial::className(), ['id' => 'identification_card_initial_id']);
    }
    
    /**
     * @return String
     */
    public function getIdentificationCardInitialName()
    {
        $card_initial = new IdentificationCardInitial();

        $result = $card_initial->findOne($this->identification_card_initial_id);

        return $result->initial;
        
    }
    
    /**
    * get list of customer types for dropdown
    */
    public static function getIdentificationCardInitialList(){
        $droptions = IdentificationCardInitial::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'id', 'initial');
    }
    
    /**
     * @return Integer
     */
    public function getIdentificationCardTypeId()
    {
        $card_initial = new IdentificationCardInitial();

        $result = $card_initial->findOne($this->identification_card_initial_id);

        return $result->identification_card_type_id;
        
    }
    
    /**
     * @return String
     */
    public function getIdentificationCardTypeName()
    {
        $card_type = new IdentificationCardType();

        $result = $card_type->findOne($this->getIdentificationCardTypeId());

        return $result->name;
        
    }
    
    /**
    * get list of customer types for dropdown
    */
    public static function getIdentificationCardTypeList(){
        $droptions = IdentificationCardType::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'id', 'name');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerTypeValue()
    {
        $card_type = new IdentificationCardType();

        $result = $card_type->findOne($this->getIdentificationCardTypeId());

        return $result->customer_type_value;
        
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerTypeId()
    {
        $card_type = new CustomerType();

        $result = $card_type->findOne(['customer_type_value' => $this->getCustomerTypeValue()]);

        return $result->id;
        
    }
    
    /**
     * @return String
     */
    public function getCustomerTypeName()
    {
        $customer_type = new CustomerType();

        $result = $customer_type->findOne(['customer_type_value' => $this->getCustomerTypeValue()]);

        return $result->customer_type_name;
        
    }
    
    /**
    * get list of customer types for dropdown
    */
    public static function getCustomerTypeList(){
        $droptions = CustomerType::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'customer_type_value', 'customer_type_name');
    }
}
