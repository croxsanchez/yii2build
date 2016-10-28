<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "identification_card_initial".
 *
 * @property integer $id
 * @property string $initial
 * @property integer $identification_card_type_id
 *
 * @property CustomerIdentificationCard[] $customerIdentificationCards
 * @property IdentificationCardType $identificationCardType
 * @property SellerIdentificationCard[] $sellerIdentificationCards
 */
class IdentificationCardInitial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'identification_card_initial';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['initial', 'identification_card_type_id'], 'required'],
            [['identification_card_type_id'], 'integer'],
            [['initial'], 'string', 'max' => 1],
            [['identification_card_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => IdentificationCardType::className(), 'targetAttribute' => ['identification_card_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'initial' => 'Initial',
            'identification_card_type_id' => 'Identification Card Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerIdentificationCards()
    {
        return $this->hasMany(CustomerIdentificationCard::className(), ['identification_card_initial_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdentificationCardType()
    {
        return $this->hasOne(IdentificationCardType::className(), ['id' => 'identification_card_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSellerIdentificationCards()
    {
        return $this->hasMany(SellerIdentificationCard::className(), ['identification_card_initial_id' => 'id']);
    }
}
