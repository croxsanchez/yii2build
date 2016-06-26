<?php

use yii\db\Migration;

class m160603_163713_create_domain_status extends Migration
{
    public function up()
    {
        $this->createTable('domain_status', [
            'id' => $this->primaryKey(),
            'value' => $this->smallinteger()->notnull()->defaultValue(10),
            'name' => $this->string()->notnull()
        ]);
    }

    public function down()
    {
        $this->dropTable('domain_status');
    }
}
