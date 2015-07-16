<?php

use yii\db\Schema;
use yii\db\Migration;

class m150625_194919_create_order_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('order', [
            'id' => 'pk',
            'user_id'=> Schema::TYPE_INTEGER,            
            'first_name'=> Schema::TYPE_STRING,
            'last_name'=> Schema::TYPE_STRING,
            'state'=> Schema::TYPE_STRING,
            'city'=> Schema::TYPE_STRING,
            'adress'=> Schema::TYPE_STRING,
            'telephone'=> Schema::TYPE_STRING,
            'email'=> Schema::TYPE_STRING,
            'delivery_id'=> Schema::TYPE_INTEGER,
            'delivery_price'=> Schema::TYPE_INTEGER,
            'payment_id'=> Schema::TYPE_INTEGER,
            'total_price'=> Schema::TYPE_INTEGER,
            'status'=> Schema::TYPE_STRING,
            'created_at'=> Schema::TYPE_INTEGER,
            'updated_at'=> Schema::TYPE_INTEGER,
            'created_by'=> Schema::TYPE_INTEGER,
            'updated_by'=> Schema::TYPE_INTEGER,
        ],$tableOptions); 

        $this->createTable('order_items', [
            'id' => 'pk',
            'order_id'=> Schema::TYPE_INTEGER,            
            'item_id'=> Schema::TYPE_INTEGER,
            'item_name'=> Schema::TYPE_STRING,
            'item_size'=> Schema::TYPE_STRING,
            'item_quantity'=> Schema::TYPE_INTEGER,
            'item_price'=> Schema::TYPE_INTEGER,
        ],$tableOptions);         
    }

    public function down()
    {
        $this->dropTable('order');
        $this->dropTable('order_items');
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
