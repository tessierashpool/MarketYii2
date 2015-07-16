<?php

use yii\db\Schema;
use yii\db\Migration;

class m150508_175742_create_params_tocategorise_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('parameters_to_categories', [
            'id' => 'pk',
            'id_category' => Schema::TYPE_INTEGER ,
            'id_parameter'=> Schema::TYPE_INTEGER,
            'order'=> Schema::TYPE_INTEGER,
        ],$tableOptions);  
    }

    public function down()
    {
        $this->dropTable('parameters_to_categories');
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
