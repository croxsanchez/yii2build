<?php

use yii\db\Migration;

class m160925_232513_add_total_points_column_to_seller extends Migration
{
    public function up()
    {
        $this->addColumn('seller', 'total_points', $this->integer()->notnull()->defaultValue(0));
        $this->addColumn('seller', 'rank_value', $this->smallinteger()->notnull()->defaultValue(10));
        $this->addColumn('seller', 'rank_date', $this->dateTime()->notnull());
        $this->addColumn('seller', 'credits', $this->integer()->notnull()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('seller', 'total_points');
        $this->dropColumn('seller', 'rank_value');
        $this->dropColumn('seller', 'rank_date');
        $this->dropColumn('seller', 'credits');
    }
}
