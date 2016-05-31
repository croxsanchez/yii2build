<?php

use yii\db\Migration;

class m160521_141842_init_email_table extends Migration
{
    public function up()
    {
        $this->createTable(
                'email',
                [
                    'id' => 'pk',
                    'purpose' => 'string',
                    'address' => 'string',
                    'customer_id' => 'int not null'
                ]
        );
        $this->addForeignKey('customer_email', 'email',
        'customer_id', 'customer', 'id');
    }

    public function down()
    {
        echo "m160521_141842_init_email_table cannot be reverted.\n";

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
