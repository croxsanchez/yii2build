<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "seller_identification_card".
 *
 * @property integer $id
 * @property string $number
 * @property integer $seller_id
 * @property integer $identification_card_initial_id
 *
 * @property IdentificationCardInitial $identificationCardInitial
 */
class SellerIdentificationCard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seller_identification_card';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'seller_id', 'identification_card_initial_id'], 'required'],
            [['seller_id', 'identification_card_initial_id'], 'integer'],
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
            'seller_id' => 'Seller ID',
            'identification_card_initial_id' => 'Identification Card Initial ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdentificationCardInitial()
    {
        return $this->hasOne(IdentificationCardInitial::className(), ['id' => 'identification_card_initial_id']);
    }
}
