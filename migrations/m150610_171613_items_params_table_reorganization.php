<?php

use yii\db\Schema;
use yii\db\Migration;

class m150610_171613_items_params_table_reorganization extends Migration
{
    public function up()
    {
        $this->createTable('i_parameters_search', [
            'id' => 'pk',
            'item_id'=> Schema::TYPE_INTEGER,
            'parameter_id'=> Schema::TYPE_INTEGER,
            'value'=> Schema::TYPE_STRING,
            'quantity' => Schema::TYPE_INTEGER,
            'type' => 'VARCHAR(1) NOT NULL'
        ]); 
        $this->createTable('i_parameters_simple', [
            'id' => 'pk',
            'item_id'=> Schema::TYPE_INTEGER,
            'parameter_id'=> Schema::TYPE_INTEGER,
            'value'=> Schema::TYPE_STRING,
            'quantity' => Schema::TYPE_INTEGER,
            'type' => 'VARCHAR(1) NOT NULL'
        ]);         
        $this->createIndex('i_p_values','i_parameters_search', 'value');    
        $this->addColumn('param_names', 'use_in_search', Schema::TYPE_BOOLEAN);    
    }

    public function down()
    {
        $this->dropColumn('param_names', 'use_in_search'); 
        $this->dropIndex('i_p_values','i_parameters_search'); 
        $this->dropTable('i_parameters_simple');        
        $this->dropTable('i_parameters_search');               
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
