<?php

use yii\db\Schema;
use yii\db\Migration;

class m150524_111749_add_colums_to_items_table extends Migration
{
    public function up()
    {
        $this->addColumn('items', 'quantity', Schema::TYPE_INTEGER);    
        $this->addColumn('items', 'status', Schema::TYPE_STRING);   
    }

    public function down()
    {
        $this->dropColumn('items', 'quantity');
        $this->dropColumn('items', 'status');
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
