<?php

use yii\db\Schema;
use yii\db\Migration;

class m150617_123632_profile_update extends Migration
{
    public function up()
    {
        $this->addColumn('profile', 'lastName', 'string');
        $this->addColumn('profile', 'city', 'string');

    }

    public function down()
    {
        $this->dropColumn('profile', 'lastName');
        $this->dropColumn('profile', 'city');
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
