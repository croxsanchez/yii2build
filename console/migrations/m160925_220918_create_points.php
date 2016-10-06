<?php

use yii\db\Migration;

class m160925_220918_create_points extends Migration
{
    public function up()
    {
        $this->createTable('points', [
            'id' => $this->primaryKey(),
            'seller_id' => $this->integer()->notnull(),
            'date' => $this->dateTime(),
            'points' => $this->integer()->notnull()->defaultValue(0)
        ]);
        
        // creates index for column `seller_id`
        $this->createIndex(
            'idx-points-seller_id',
            'points',
            'seller_id'
        );

        // add foreign key for table `seller`
        $this->addForeignKey(
            'fk-points-seller_id',
            'points',
            'seller_id',
            'seller',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        // drops foreign key for table `points`
        $this->dropForeignKey(
            'fk-points-seller_id',
            'points'
        );

        // drops index for column `seller_id`
        $this->dropIndex(
            'idx-points-seller_id',
            'points'
        );
        
        $this->dropTable('points');
    }
}
