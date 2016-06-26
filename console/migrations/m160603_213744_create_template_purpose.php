<?php

use yii\db\Migration;

class m160603_213744_create_template_purpose extends Migration
{
    public function up()
    {
        $this->createTable('template_purpose', [
            'id' => $this->primaryKey(),
            'value' => $this->smallinteger()->notnull(),
            'name' => $this->string()->notnull()
        ]);
    }

    public function down()
    {
        $this->dropTable('template_purpose');
    }
}
