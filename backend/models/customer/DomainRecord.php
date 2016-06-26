<?php

namespace backend\models\customer;

use Yii;
use common\models\User;
use backend\models\customer\CustomerRecord;
use backend\models\customer\ThemeRecord;

/**
 * This is the model class for table "domain".
 *
 * @property integer $id
 * @property string $name
 * @property integer $customer_id
 * @property integer $domain_choice_value
 * @property integer $payment_status_value
 * @property integer $domain_status_value
 * @property integer $theme_id
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property User $createdBy
 * @property Customer $customer
 * @property Theme $theme
 * @property User $updatedBy
 * @property DomainTheme[] $domainThemes
 */
class DomainRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'domain';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'customer_id', 'theme_id', 'created_by', 'updated_by'], 'required'],
            [['customer_id', 'domain_choice_value', 'payment_status_value', 'domain_status_value', 'theme_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerRecord::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['theme_id'], 'exist', 'skipOnError' => true, 'targetClass' => ThemeRecord::className(), 'targetAttribute' => ['theme_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
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
            'customer_id' => 'Customer ID',
            'domain_choice_value' => 'Domain Choice Value',
            'payment_status_value' => 'Payment Status Value',
            'domain_status_value' => 'Domain Status Value',
            'theme_id' => 'Theme ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(CustomerRecord::className(), ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTheme()
    {
        return $this->hasOne(ThemeRecord::className(), ['id' => 'theme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomainThemes()
    {
        return $this->hasMany(DomainThemeRecord::className(), ['domain_id' => 'id']);
    }
}
