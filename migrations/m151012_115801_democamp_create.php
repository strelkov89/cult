<?php

use yii\db\Schema;
use yii\db\Migration;

class m151012_115801_democamp_create extends Migration
{

    public function up()
    {
        $this->createTable('democamp', [
            'id' => 'int(11) NOT NULL PRIMARY KEY',
            'title' => 'varchar(254) DEFAULT NULL COMMENT "Название"',
            'direction' => 'int(3) DEFAULT NULL COMMENT "Направление"',
            'description' => 'text DEFAULT NULL COMMENT "Краткое резюме"',
            'stage' => 'int(3) DEFAULT NULL COMMENT "Стадия"',
            'url' => 'varchar(254) DEFAULT NULL COMMENT "Ссылка"',
            'author_id' => 'int(11) NOT NULL',
            ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->execute("ALTER TABLE `democamp` CHANGE  `id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT");
        $this->addForeignKey('fk_democamp', '{{%democamp}}', 'author_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('democamp');
    }

}