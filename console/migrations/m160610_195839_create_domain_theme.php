<?php

use yii\db\Migration;

class m160610_195839_create_domain_theme extends Migration
{
    public function up()
    {
        $this->createTable('domain_theme', [
            'id' => $this->primaryKey(),
            'domain_id' => $this->integer()->notnull(),
            'web_template_id' => $this->integer()->notnull()
        ]);
        
        // creates index for column `domain_id`
        $this->createIndex(
            'idx-domain_theme-domain_id',
            'domain_theme',
            'domain_id'
        );

        // add foreign key for table `domain`
        $this->addForeignKey(
            'fk-domain_theme-domain_id',
            'domain_theme',
            'domain_id',
            'domain',
            'id',
            'CASCADE'
        );
        
        // creates index for column `web_template_id`
        $this->createIndex(
            'idx-domain_theme-web_template_id',
            'domain_theme',
            'web_template_id'
        );

        // add foreign key for table `domain`
        $this->addForeignKey(
            'fk-domain_theme-web_template_id',
            'domain_theme',
            'web_template_id',
            'web_template',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        // drops foreign key for table `domain_theme`
        $this->dropForeignKey(
            'fk-domain_theme-domain_id',
            'domain_theme'
        );

        // drops index for column `theme_id`
        $this->dropIndex(
            'idx-domain_theme-domain_id',
            'domain_theme'
        );
        
        // drops foreign key for table `web_template`
        $this->dropForeignKey(
            'fk-domain_theme-web_template_id',
            'domain_theme'
        );

        // drops index for column `theme_id`
        $this->dropIndex(
            'idx-domain_theme-web_template_id',
            'domain_theme'
        );
        
        $this->dropTable('domain_theme');
    }
}
