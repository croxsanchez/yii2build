<?php

use yii\db\Migration;

class m160614_143836_create_domain_choice extends Migration
{
    public function up()
    {
        $this->createTable('domain_choice', [
            'id' => $this->primaryKey(),
            'order' => $this->string()->notnull(),
            'value' => $this->smallinteger()->notnull()
        ]);
    }

    public function down()
    {
        $this->dropTable('domain_choice');
    }
}
