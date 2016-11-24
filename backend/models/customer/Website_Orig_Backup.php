<?php

namespace backend\models\customer;

use Yii;

/**
 * This is the model class for table "website".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property string $description
 * @property integer $theme_id
 *
 * @property Domain[] $domains
 * @property Customer $customer
 * @property Theme $theme
 */
class Website extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'website';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'theme_id'], 'required'],
            [['customer_id', 'theme_id'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerRecord::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['theme_id'], 'exist', 'skipOnError' => true, 'targetClass' => ThemeRecord::className(), 'targetAttribute' => ['theme_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'description' => 'Description',
            'theme_id' => 'Theme ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomains()
    {
        return $this->hasMany(Domain::className(), ['website_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTheme()
    {
        return $this->hasOne(Theme::className(), ['id' => 'theme_id']);
    }
}
