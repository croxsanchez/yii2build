<?php

use yii\db\Migration;

class m160603_155901_create_identification_card_type extends Migration
{
    public function up()
    {
        $this->createTable('identification_card_type', [
            'id' => $this->primaryKey(),
            'value' => $this->smallinteger()->notnull()->defaultValue(10),
            'name' => $this->string()->notnull()
        ]);
    }

    public function down()
    {
        $this->dropTable('identification_card_type');
    }
}
