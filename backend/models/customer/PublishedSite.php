<?php

namespace backend\models\customer;

use Yii;
use backend\models\customer\CustomerRecord;
use backend\models\Designer;
use backend\models\Seller;
use common\models\User;

/**
 * This is the model class for table "temporary_site".
 *
 * @property integer $id
 * @property string $url
 * @property boolean $url_status
 * @property integer $website_id
 * @property integer $designer_id
 * @property integer $seller_id
 * @property integer $customer_id
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property Customer $customer
 * @property Designer $designer
 * @property Seller $seller
 * @property User $createdBy
 * @property User $updatedBy
 * @property Website $website
 */
class TemporarySite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'temporary_site';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'url_status'], 'required'],
            [['url_status'], 'boolean'],
            [['website_id', 'designer_id', 'seller_id', 'customer_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['url'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerRecord::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['designer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Designer::className(), 'targetAttribute' => ['designer_id' => 'id']],
            [['seller_id'], 'exist', 'skipOnError' => true, 'targetClass' => Seller::className(), 'targetAttribute' => ['seller_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['website_id'], 'exist', 'skipOnError' => true, 'targetClass' => Website::className(), 'targetAttribute' => ['website_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'url_status' => 'Url Status',
            'website_id' => 'Website ID',
            'designer_id' => 'Designer ID',
            'seller_id' => 'Seller ID',
            'customer_id' => 'Customer ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
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
    public function getDesigner()
    {
        return $this->hasOne(Designer::className(), ['id' => 'designer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeller()
    {
        return $this->hasOne(Seller::className(), ['id' => 'seller_id']);
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
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebsite()
    {
        return $this->hasOne(Website::className(), ['id' => 'website_id']);
    }
}
