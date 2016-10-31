<?php

namespace backend\models;

use backend\models\customer\DomainRecord;

use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property integer $id
 * @property string $ref_number
 * @property double $amount
 * @property integer $domain_id
 * @property string $due_date
 * @property integer $payment_status_value
 *
 * @property Domain $domain
 * @property Payment[] $payments
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ref_number', 'amount', 'domain_id', 'due_date'], 'required'],
            [['amount'], 'number'],
            [['domain_id', 'payment_status_value'], 'integer'],
            [['due_date'], 'safe'],
            [['ref_number'], 'string', 'max' => 255],
            [['ref_number'], 'unique'],
            [['domain_id'], 'exist', 'skipOnError' => true, 'targetClass' => DomainRecord::className(), 'targetAttribute' => ['domain_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ref_number' => 'Ref Number',
            'amount' => 'Amount',
            'domain_id' => 'Domain ID',
            'due_date' => 'Due Date',
            'payment_status_value' => 'Payment Status Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomain()
    {
        return $this->hasOne(Domain::className(), ['id' => 'domain_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['invoice_id' => 'id']);
    }
}
