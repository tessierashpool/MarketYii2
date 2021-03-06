<?php

use yii\db\Schema;
use yii\db\Migration;

class m150524_123114_creat_categories_variants_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('variants_to_categories', [
            'id' => 'pk',
            'id_category'=> Schema::TYPE_INTEGER,
            'id_variant'=> Schema::TYPE_INTEGER,
            'order'=> Schema::TYPE_INTEGER,
        ],$tableOptions); 
        $this->addColumn('categories', 'have_variants', Schema::TYPE_BOOLEAN);   
    }

    public function down()
    {
        $this->dropTable('variants_to_categories');
        $this->dropColumn('categories', 'have_variants');
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
