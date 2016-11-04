<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "seller_address".
 *
 * @property integer $id
 * @property string $purpose
 * @property string $country
 * @property string $state
 * @property string $city
 * @property string $street
 * @property string $building
 * @property string $apartment
 * @property string $postal_code
 * @property integer $seller_id
 *
 * @property Seller $seller
 */
class SellerAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seller_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purpose', 'country', 'state', 'city', 'street', 'building', 'apartment', 'postal_code', 'seller_id'], 'required'],
            [['seller_id'], 'integer'],
            [['purpose'], 'string', 'max' => 12],
            [['country', 'state', 'city', 'building', 'apartment'], 'string', 'max' => 50],
            [['street'], 'string', 'max' => 255],
            [['postal_code'], 'string', 'max' => 20],
            [['seller_id'], 'exist', 'skipOnError' => true, 'targetClass' => Seller::className(), 'targetAttribute' => ['seller_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'purpose' => 'Purpose',
            'country' => 'Country',
            'state' => 'State',
            'city' => 'City',
            'street' => 'Street',
            'building' => 'Building',
            'apartment' => 'Apartment',
            'postal_code' => 'Postal Code',
            'seller_id' => 'Seller ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeller()
    {
        return $this->hasOne(Seller::className(), ['id' => 'seller_id']);
    }
}
