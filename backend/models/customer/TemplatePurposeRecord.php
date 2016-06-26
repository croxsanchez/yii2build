<?php

namespace backend\models\customer;

use Yii;

/**
 * This is the model class for table "template_purpose".
 *
 * @property integer $id
 * @property integer $value
 * @property string $name
 */
class TemplatePurposeRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template_purpose';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'name'], 'required'],
            [['value'], 'integer'],
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
