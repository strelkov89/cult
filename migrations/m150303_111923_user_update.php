<?php

use yii\db\Schema;
use yii\db\Migration;

class m150303_111923_user_update extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'phone', 'varchar(36) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('user', 'phone');
    }

    /*
      // Use safeUp/safeDown to run migration code within a transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
