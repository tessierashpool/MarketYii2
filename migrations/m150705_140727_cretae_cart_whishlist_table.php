<?php

use yii\db\Schema;
use yii\db\Migration;

class m150705_140727_cretae_cart_whishlist_table extends Migration
{
    public function up()
    {
        $this->createTable('cart', [
            'id' => 'pk',
            'user_id'=> Schema::TYPE_INTEGER,
            'item_id'=> Schema::TYPE_INTEGER,
            'scode'=> Schema::TYPE_TEXT,
            'sname'=> Schema::TYPE_TEXT,
            'quantity'=> Schema::TYPE_INTEGER,
        ]); 
        $this->createTable('whishlist', [
            'id' => 'pk',
            'user_id'=> Schema::TYPE_INTEGER,
            'item_id'=> Schema::TYPE_INTEGER,
        ]);         
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
