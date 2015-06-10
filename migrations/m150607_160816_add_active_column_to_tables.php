<?php

use yii\db\Schema;
use yii\db\Migration;

class m150607_160816_add_active_column_to_tables extends Migration
{
    public function up()
    {
        $this->addColumn('param_names', 'active', Schema::TYPE_BOOLEAN);  
        $this->addColumn('categories', 'active', Schema::TYPE_BOOLEAN);  
        $this->addColumn('items', 'active', Schema::TYPE_BOOLEAN);  
    }

    public function down()
    {
        $this->dropColumn('param_names', 'active');
        $this->dropColumn('categories', 'active');
        $this->dropColumn('items', 'active');
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
