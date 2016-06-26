<?php

use yii\db\Migration;

class m160603_163135_create_theme extends Migration
{
    public function up()
    {
        $this->createTable('theme', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notnull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
    }

    public function down()
    {
        $this->dropTable('theme');
    }
}
