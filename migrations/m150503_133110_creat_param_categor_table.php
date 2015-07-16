<?php

use yii\db\Schema;
use yii\db\Migration;

class m150503_133110_creat_param_categor_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('param_categor', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING ,
        ],$tableOptions);        
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
