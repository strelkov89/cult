<?php

use yii\db\Schema;
use yii\db\Migration;

class m150203_084953_project_create extends Migration
{
    public function up()
    {
        $this->createTable('project', [
            'id' => 'int(11) NOT NULL PRIMARY KEY',
            'created_at' => 'int(11) NOT NULL',
            'updated_at' => 'int(11) DEFAULT NULL',
            //--
            'title' => 'varchar(255) NOT NULL',
            'description' => 'text NOT NULL',
            'author_id' => 'int(11) DEFAULT NULL',
            'need_coder' => 'TINYINT(1) NOT NULL DEFAULT 0',
            'need_designer' => 'TINYINT(1) NOT NULL DEFAULT 0',
            'need_ux' => 'TINYINT(1) NOT NULL DEFAULT 0',
            'status' => 'TINYINT(4) NOT NULL DEFAULT 0',
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->execute("ALTER TABLE `project` CHANGE  `id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT");
        $this->addForeignKey('fk_project', '{{%project}}', 'author_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('project');
    }

}
