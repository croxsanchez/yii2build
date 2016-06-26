<?php

use yii\db\Migration;

class m160603_163636_create_domain extends Migration
{
    public function up()
    {
        $this->createTable('domain', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notnull(),
            'customer_id' => $this->integer()->notnull(),
            'domain_preferred_value' => $this->smallinteger()->notnull()->defaultValue(10),
            'payment_status_value' => $this->smallinteger()->notnull()->defaultValue(10),
            'domain_status_value' => $this->smallinteger()->notnull()->defaultValue(10),
            'theme_id' => $this->integer()->notnull(),
            'created_at' => $this->dateTime(),
            'created_by' => $this->integer()->notnull(),
            'updated_at' => $this->dateTime(),
            'updated_by' => $this->integer()->notnull()
        ]);
        
        // creates index for column `customer_id`
        $this->createIndex(
            'idx-domain-customer_id',
            'domain',
            'customer_id'
        );

        // add foreign key for table `customer`
        $this->addForeignKey(
            'fk-domain-customer_id',
            'domain',
            'customer_id',
            'customer',
            'id',
            'CASCADE'
        );
        
        // creates index for column `theme_id`
        $this->createIndex(
            'idx-domain-theme_id',
            'domain',
            'theme_id'
        );

        // add foreign key for table `theme`
        $this->addForeignKey(
            'fk-domain-theme_id',
            'domain',
            'theme_id',
            'theme',
            'id',
            'CASCADE'
        );
        
        // creates index for column `created_by`
        $this->createIndex(
            'idx-domain-created_by',
            'domain',
            'created_by'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-domain-created_by',
            'domain',
            'created_by',
            'user',
            'id',
            'CASCADE'
        );
        
        // creates index for column `updated_by`
        $this->createIndex(
            'idx-domain-updated_by',
            'domain',
            'updated_by'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-domain-updated_by',
            'domain',
            'updated_by',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        // drops foreign key for table `customer`
        $this->dropForeignKey(
            'fk-domain-customer_id',
            'domain'
        );

        // drops index for column `customer_id`
        $this->dropIndex(
            'idx-domain-customer_id',
            'domain'
        );
        
        // drops foreign key for table `theme`
        $this->dropForeignKey(
            'fk-domain-theme_id',
            'domain'
        );

        // drops index for column `theme_id`
        $this->dropIndex(
            'idx-domain-theme_id',
            'domain'
        );
        
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-domain-created_by',
            'domain'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            'idx-domain-created_by',
            'domain'
        );
        
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-domain-updated_by',
            'domain'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            'idx-domain-updated_by',
            'domain'
        );
        
        $this->dropTable('domain');
    }
}
