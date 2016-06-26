<?php

namespace backend\models\customer;

use Yii;

/**
 * This is the model class for table "identification_card_initial".
 *
 * @property integer $id
 * @property integer $value
 * @property string $initial
 * @property integer $identification_card_type_value
 */
class IdentificationCardInitialRecord extends \yii\db\ActiveRecord
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
            [['value', 'initial', 'identification_card_type_value'], 'required'],
            [['value', 'identification_card_type_value'], 'integer'],
            [['initial'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'initial' => 'Initial',
            'identification_card_type_value' => 'Identification Card Type Value',
        ];
    }
}
