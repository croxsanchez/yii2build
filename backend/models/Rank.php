<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "rank".
 *
 * @property integer $id
 * @property integer $value
 * @property string $name
 */
class Rank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rank';
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
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getSellers(){
        return $this->hasMany(Seller::className(), ['rank_value' => 'value']);
    }
}
