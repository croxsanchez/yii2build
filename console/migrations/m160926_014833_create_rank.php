<?php

use yii\db\Migration;

class m160926_014833_create_rank extends Migration
{
    public function up()
    {
        $this->createTable('rank', [
            'id' => $this->primaryKey(),
            'value' => $this->smallinteger()->notnull(),
            'name' => $this->string()->notnull()
        ]);
    }

    public function down()
    {
        $this->dropTable('rank');
    }
}
