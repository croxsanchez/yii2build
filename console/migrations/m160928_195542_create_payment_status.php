<?php

use yii\db\Migration;

class m160928_195542_create_payment_status extends Migration
{
    public function up()
    {
        $this->createTable('payment_status', [
            'id' => $this->primaryKey(),
            'value' => $this->smallinteger()->notnull()->defaultValue(10),
            'name' => $this->string()->notnull()
        ]);
    }

    public function down()
    {
        $this->dropTable('payment_status');
    }
}
