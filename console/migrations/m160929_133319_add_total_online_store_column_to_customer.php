<?php

use yii\db\Migration;

class m160929_133319_add_total_online_store_column_to_customer extends Migration
{
    public function up()
    {
        $this->addColumn('customer', 'online_store', $this->boolean()->notnull()->defaultValue(false));
        $this->addColumn('customer', 'social_media', $this->boolean()->notnull()->defaultValue(false));
    }

    public function down()
    {
        $this->dropColumn('customer', 'online_store');
        $this->dropColumn('customer', 'social_media');
    }
}
