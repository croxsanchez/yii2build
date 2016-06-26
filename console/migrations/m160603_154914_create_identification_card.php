<?php

use yii\db\Migration;

class m160603_154914_create_identification_card extends Migration
{
    public function up()
    {
        $this->createTable('identification_card', [
            'id' => $this->primaryKey(),
            'number' => $this->string()->notnull()->unique(),
            'customer_id' => $this->integer()->notnull(),
            'identification_card_type_value' => $this->smallinteger()->notnull()->defaultValue(10)
        ]);
        
        // creates index for column `customer_id`
        $this->createIndex(
            'idx-identification_card-customer_id',
            'identification_card',
            'customer_id'
        );

        // add foreign key for table `customser`
        $this->addForeignKey(
            'fk-identification_card-customer_id',
            'identification_card',
            'customer_id',
            'customer',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        // drops foreign key for table `customer`
        $this->dropForeignKey(
            'fk-identification_card-customer_id',
            'identification_card'
        );

        // drops index for column `customer_id`
        $this->dropIndex(
            'idx-identification_card-customer_id',
            'identification_card'
        );
        
        $this->dropTable('identification_card');
    }
}
