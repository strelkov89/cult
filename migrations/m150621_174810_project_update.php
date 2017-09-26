<?php

use yii\db\Schema;
use yii\db\Migration;

class m150621_174810_project_update extends Migration
{

    public function up()
    {
        $this->addColumn('project', 'is_deleted', 'integer DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('project', 'is_deleted');
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