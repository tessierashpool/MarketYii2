<?php

use yii\db\Schema;
use yii\db\Migration;

class m150518_183946_create_parameters_types extends Migration
{
    public function up()
    {
        $this->createTable('lists_to_parameters', [
            'id' => 'pk',
            'parameter_id'=> Schema::TYPE_INTEGER,
            'code'=> Schema::TYPE_STRING,
            'value'=> Schema::TYPE_STRING,
            'order'=> Schema::TYPE_INTEGER,
        ]); 

        $this->addColumn('param_names', 'type', Schema::TYPE_STRING);         
    }

    public function down()
    {
        $this->dropTable('lists_to_parameters');
        $this->dropColumn('param_names', 'type'); 
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
