<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "identification_card_type".
 *
 * @property integer $id
 * @property string $name
 *
 * @property IdentificationCardInitial[] $identificationCardInitials
 */
class IdentificationCardType extends \yii\db\ActiveRecord
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
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdentificationCardInitials()
    {
        return $this->hasMany(IdentificationCardInitial::className(), ['identification_card_type_id' => 'id']);
    }
}
