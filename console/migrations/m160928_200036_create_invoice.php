<?php

use yii\db\Migration;

class m160928_200036_create_invoice extends Migration
{
    public function up()
    {
        $this->createTable('invoice', [
            'id' => $this->primaryKey(),
            'ref_number' => $this->string()->notnull(),
            'amount' => $this->float()->notnull(),
            'domain_id' => $this->integer()->notnull(),
            'due_date' => $this->dateTime()->notnull(),
            'payment_status_value' => $this->smallinteger()->notnull()->defaultValue(10),
        ]);
        
        // creates index for column `domain_id`
        $this->createIndex(
            'idx-invoice-domain_id',
            'invoice',
            'domain_id'
        );

        // add foreign key for table `seller`
        $this->addForeignKey(
            'fk-invoice-domain_id',
            'invoice',
            'domain_id',
            'domain',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        // drops foreign key for table `domain`
        $this->dropForeignKey(
            'fk-invoice-domain_id',
            'invoice'
        );
        
        // drops index for column `domain_id`
        $this->dropIndex(
            'idx-invoice-domain_id',
            'invoice'
        );
        
        $this->dropTable('invoice');
    }
}
