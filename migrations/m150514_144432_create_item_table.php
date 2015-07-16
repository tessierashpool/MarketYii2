<?php

use yii\db\Schema;
use yii\db\Migration;

class m150514_144432_create_item_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('items', [
            'id' => 'pk',
            'name'=> Schema::TYPE_STRING,
            'description'=> Schema::TYPE_TEXT,
            'price'=> Schema::TYPE_INTEGER,
            'category_id'=> Schema::TYPE_INTEGER,
            'created_at'=> Schema::TYPE_INTEGER,
            'updated_at'=> Schema::TYPE_INTEGER,
            'created_by'=> Schema::TYPE_INTEGER,
            'updated_by'=> Schema::TYPE_INTEGER,
        ],$tableOptions); 
    }

    public function down()
    {
        $this->dropTable('items');
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
