<?php

use yii\db\Migration;

class m160928_195457_create_payment_method extends Migration
{
    public function up()
    {
        $this->createTable('payment_method', [
            'id' => $this->primaryKey(),
            'value' => $this->integer()->notnull(),
            'type' => $this->string()->notnull()
        ]);
    }

    public function down()
    {
        $this->dropTable('payment_method');
    }
}
