<?php

use yii\db\Schema;
use yii\db\Migration;

class m150624_164607_create_delivery_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('delivery', [
            'id' => 'pk',
            'active'=> Schema::TYPE_BOOLEAN,
            'name'=> Schema::TYPE_STRING,
            'description'=> Schema::TYPE_TEXT,
            'price'=> Schema::TYPE_INTEGER,
            'created_at'=> Schema::TYPE_INTEGER,
            'updated_at'=> Schema::TYPE_INTEGER,
            'created_by'=> Schema::TYPE_INTEGER,
            'updated_by'=> Schema::TYPE_INTEGER
        ],$tableOptions); 

        $this->insert('delivery', [
            'active' => "1",
            'name' => 'Delivery',
        ]);             
    }

    public function down()
    {
        $this->dropTable('delivery');
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
