<?php

use yii\db\Schema;
use yii\db\Migration;

class m150527_154947_create_items_variants_table extends Migration
{
    public function up()
    {
        $this->createTable('items_variants', [
            'id' => 'pk',
            'id_item'=> Schema::TYPE_INTEGER,
            'parent_id'=> Schema::TYPE_INTEGER,
            'code'=> Schema::TYPE_STRING,
            'quantity'=> Schema::TYPE_INTEGER,
        ]); 
    }

    public function down()
    {
        $this->dropTable('items_variants');
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
