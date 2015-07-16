<?php

use yii\db\Schema;
use yii\db\Migration;

class m150705_140727_cretae_cart_whishlist_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('cart', [
            'id' => 'pk',
            'user_id'=> Schema::TYPE_INTEGER,
            'item_id'=> Schema::TYPE_INTEGER,
            'scode'=> Schema::TYPE_TEXT,
            'sname'=> Schema::TYPE_TEXT,
            'quantity'=> Schema::TYPE_INTEGER,
        ],$tableOptions); 
        $this->createTable('whishlist', [
            'id' => 'pk',
            'user_id'=> Schema::TYPE_INTEGER,
            'item_id'=> Schema::TYPE_INTEGER,
        ],$tableOptions);         
    }

    public function down()
    {
        $this->dropTable('cart');
        $this->dropTable('whishlist');
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
