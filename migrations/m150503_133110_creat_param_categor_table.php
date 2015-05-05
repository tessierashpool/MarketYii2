<?php

use yii\db\Schema;
use yii\db\Migration;

class m150503_133110_creat_param_categor_table extends Migration
{
    public function up()
    {
        $this->createTable('param_categor', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING ,
        ]);        
    }

    public function down()
    {
        $this->dropTable('param_categor');
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
