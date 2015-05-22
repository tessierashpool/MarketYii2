<?php

use yii\db\Schema;
use yii\db\Migration;

class m150522_123028_create_items_parameters_value extends Migration
{
    public function up()
    {
        $this->createTable('items_parameters_value', [
            'id' => 'pk',
            'item_id'=> Schema::TYPE_INTEGER,
            'parameter_id'=> Schema::TYPE_INTEGER,
            'value'=> Schema::TYPE_STRING,
        ]); 
    }

    public function down()
    {
        $this->dropTable('items_parameters_value');
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
