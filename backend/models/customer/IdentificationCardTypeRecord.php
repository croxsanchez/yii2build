<?php

namespace backend\models\customer;

use Yii;

/**
 * This is the model class for table "identification_card_type".
 *
 * @property integer $id
 * @property integer $value
 * @property string $name
 */
class IdentificationCardTypeRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'identification_card_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
            'name' => 'Name',
        ];
    }
}
