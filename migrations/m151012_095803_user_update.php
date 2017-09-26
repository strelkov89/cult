<?php

use yii\db\Schema;
use yii\db\Migration;

class m151012_095803_user_update extends Migration
{
   public function up()
    {
        $this->addColumn('user', 'type', 'TINYINT(2) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('user', 'type');
    }
}
