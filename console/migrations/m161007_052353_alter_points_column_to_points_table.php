<?php

use yii\db\Migration;

class m161007_052353_alter_points_column_to_points_table extends Migration
{
    public function up()
    {
        $this->alterColumn('points', 'points', $this->float());
    }

    public function down()
    {
        echo "m161007_052353_alter_points_column_to_points_table cannot be reverted.\n";

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
