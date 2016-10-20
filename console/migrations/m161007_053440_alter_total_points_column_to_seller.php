<?php

use yii\db\Migration;

class m161007_053440_alter_total_points_column_to_seller extends Migration
{
    public function up()
    {
        $this->alterColumn('seller', 'total_points', $this->float());
    }

    public function down()
    {
        echo "m161007_053440_alter_total_points_column_to_seller cannot be reverted.\n";

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
