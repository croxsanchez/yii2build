<?php

use yii\db\Migration;

class m160521_140505_init_address_table extends Migration
{
    public function up()
    {
        $this->createTable(
                'address',
                [
                    'id' => 'pk',
                    'purpose' => 'string',
                    'country' => 'string',
                    'state' => 'string',
                    'city' => 'string',
                    'street' => 'string',
                    'building' => 'string',
                    'apartment' => 'string',
                    'receiver_name' => 'string',
                    'postal_code' => 'string',
                    'customer_id' => 'int not null'
                ]
        );
        
        $this->addForeignKey('customer_address', 'address',
                'customer_id', 'customer', 'id');
    }

    public function down()
    {
        echo "m160521_140505_init_address_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
