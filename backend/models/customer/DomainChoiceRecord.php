<?php

namespace backend\models\customer;

use Yii;

/**
 * This is the model class for table "domain_choice".
 *
 * @property integer $id
 * @property string $order
 * @property integer $value
 */
class DomainChoiceRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'domain_choice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order', 'value'], 'required'],
            [['value'], 'integer'],
            [['order'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order' => 'Order',
            'value' => 'Value',
        ];
    }
}
