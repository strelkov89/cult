<?php

use yii\db\Schema;
use yii\db\Migration;

class m150621_150533_user_update extends Migration
{

    public function up()
    {
        $this->addColumn('user', 'is_deleted', 'integer DEFAULT NULL');
        $this->addColumn('user', 'is_moderated', 'integer DEFAULT NULL');
        $this->addColumn('user', 'is_visited', 'integer DEFAULT NULL');
        $this->addColumn('user', 'is_admin', 'integer DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('user', 'is_deleted');
        $this->dropColumn('user', 'is_moderated');
        $this->dropColumn('user', 'is_visited');
        $this->dropColumn('user', 'is_admin');
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