<?php

use yii\db\Migration;

class m160603_160608_create_identification_card_initial extends Migration
{
    public function up()
    {
        $this->createTable('identification_card_initial', [
            'id' => $this->primaryKey(),
            'value' => $this->smallinteger()->notnull(),
            'initial' => $this->string(1)->notnull(),
            'identification_card_type_value' => $this->smallinteger()->notnull()
        ]);
    }

    public function down()
    {
        $this->dropTable('identification_card_initial');
    }
}
