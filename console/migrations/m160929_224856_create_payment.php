<?php

use yii\db\Migration;

class m160929_224856_create_payment extends Migration
{
    public function up()
    {
        $this->createTable('payment', [
            'id' => $this->primaryKey(),
            'ref_number' => $this->string()->notnull(),
            'amount' => $this->float()->notnull(),
            'date' => $this->dateTime()->notnull(),
            'payment_method_value' => $this->integer()->notnull(),
            'invoice_id' => $this->integer()->notnull(),
            'domain_id' => $this->integer()->notnull()
        ]);
        
        // creates index for column `invoice_id`
        $this->createIndex(
            'idx-payment-invoice_id',
            'payment',
            'invoice_id'
        );

        // add foreign key for table `invoice`
        $this->addForeignKey(
            'fk-payment-invoice_id',
            'payment',
            'invoice_id',
            'invoice',
            'id',
            'CASCADE'
        );
        
        // creates index for column `domain_id`
        $this->createIndex(
            'idx-payment-domain_id',
            'payment',
            'domain_id'
        );

        // add foreign key for table `domain`
        $this->addForeignKey(
            'fk-payment-domain_id',
            'payment',
            'domain_id',
            'domain',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        // drops foreign key for table `invoice`
        $this->dropForeignKey(
            'fk-payment-invoice_id',
            'payment'
        );
        
        // drops index for column `invoice_id`
        $this->dropIndex(
            'idx-payment-invoice_id',
            'payment'
        );
        
        // drops foreign key for table `domain`
        $this->dropForeignKey(
            'fk-payment-domain_id',
            'payment'
        );
        
        // drops index for column `domain_id`
        $this->dropIndex(
            'idx-payment-domain_id',
            'payment'
        );
        
        $this->dropTable('payment');
    }
}
