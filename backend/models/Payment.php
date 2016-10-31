<?php

namespace backend\models;

use backend\models\customer\DomainRecord;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property integer $id
 * @property double $amount
 * @property string $date
 * @property integer $payment_method_value
 * @property integer $invoice_id
 * @property integer $domain_id
 *
 * @property Domain $domain
 * @property Invoice $invoice
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount', 'date', 'payment_method_value', 'invoice_id', 'domain_id'], 'required'],
            [['amount'], 'number'],
            [['date'], 'safe'],
            [['payment_method_value', 'invoice_id', 'domain_id'], 'integer'],
            [['domain_id'], 'exist', 'skipOnError' => true, 'targetClass' => DomainRecord::className(), 'targetAttribute' => ['domain_id' => 'id']],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::className(), 'targetAttribute' => ['invoice_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'Amount',
            'date' => 'Date',
            'payment_method_value' => 'Payment Method Value',
            'invoice_id' => 'Invoice ID',
            'domain_id' => 'Domain ID',
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
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'invoice_id']);
    }
}
