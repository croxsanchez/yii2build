<?php

use yii\db\Migration;

class m161008_173921_add_filename_column_to_profile extends Migration
{
    public function up()
    {
        $this->addColumn('profile', 'filename', $this->string()->notnull()->defaultValue(""));
        $this->addColumn('profile', 'avatar', $this->string()->notnull()->defaultValue(""));
    }

    public function down()
    {
        $this->dropColumn('profile', 'filename');
        $this->dropColumn('profile', 'avatar');
    }
}
