<?php

use yii\db\Schema;
use yii\db\Migration;

class m150205_113020_request_create extends Migration
{
    public function up()
    {
        $this->createTable('request', [
            'id' => 'int(11) NOT NULL PRIMARY KEY',
            'user_id' => 'int(11) NOT NULL',
            'project_id' => 'int(11) NOT NULL',
            'status' => 'TINYINT(4) NOT NULL DEFAULT 0',
                ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->execute("ALTER TABLE `request` CHANGE  `id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT");
        $this->addForeignKey('fk_request_user', '{{%request}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_request_project', '{{%request}}', 'project_id', '{{%project}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('request');
    }
}
