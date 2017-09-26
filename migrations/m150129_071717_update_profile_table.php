<?php

use yii\db\Schema;
use yii\db\Migration;

class m150129_071717_update_profile_table extends Migration
{
    public function up()
    {
        $this->dropColumn('profile', 'public_email');
        $this->dropColumn('profile', 'location');
        $this->dropColumn('profile', 'website');

        $this->addColumn('profile', 'is_coder', 'boolean');
        $this->addColumn('profile', 'is_designer', 'boolean');
        $this->addColumn('profile', 'is_ux', 'boolean');
        $this->addColumn('profile', 'portfolio_images', 'text');
        $this->addColumn('profile', 'portfolio_links', 'text');

    }

    public function down()
    {
        $this->dropColumn('profile', 'portfolio_links');
        $this->dropColumn('profile', 'portfolio_images');
        $this->dropColumn('profile', 'is_ux');
        $this->dropColumn('profile', 'is_designer');
        $this->dropColumn('profile', 'is_coder');

        $this->addColumn('profile', 'public_email', 'string');
        $this->addColumn('profile', 'location', 'string');
        $this->addColumn('profile', 'website', 'string');
    }
}
