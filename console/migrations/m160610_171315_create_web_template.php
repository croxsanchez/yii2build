<?php

use yii\db\Migration;

class m160610_171315_create_web_template extends Migration
{
    public function up()
    {
        $this->createTable('web_template', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notnull(),
            'theme_id' => $this->integer()->notnull(),
            'template_purpose_value' => $this->smallinteger()->notnull(),
            'path' => $this->string()->notnull()
        ]);
        
        // creates index for column `theme_id`
        $this->createIndex(
            'idx-web_template-theme_id',
            'web_template',
            'theme_id'
        );

        // add foreign key for table `theme`
        $this->addForeignKey(
            'fk-web_template-theme_id',
            'web_template',
            'theme_id',
            'theme',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        // drops foreign key for table `theme`
        $this->dropForeignKey(
            'fk-web_template-theme_id',
            'web_template'
        );

        // drops index for column `theme_id`
        $this->dropIndex(
            'idx-web_template-theme_id',
            'web_template'
        );
        
        $this->dropTable('web_template');
    }
}
