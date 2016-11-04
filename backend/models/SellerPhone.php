<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "seller_phone".
 *
 * @property integer $id
 * @property string $purpose
 * @property string $number
 * @property integer $seller_id
 *
 * @property Seller $seller
 */
class SellerPhone extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seller_phone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purpose', 'number', 'seller_id'], 'required'],
            [['seller_id'], 'integer'],
            [['purpose'], 'string', 'max' => 12],
            [['number'], 'string', 'max' => 20],
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
            'number' => 'Number',
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
