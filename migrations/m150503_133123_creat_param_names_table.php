<?php

use yii\db\Schema;
use yii\db\Migration;

class m150503_133123_creat_param_names_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('param_names', [
            'id' => 'pk',
            'code' => Schema::TYPE_STRING." UNIQUE" ,
            'name'=> Schema::TYPE_STRING,
            'category_id'=> Schema::TYPE_INTEGER,
            'created_at'=> Schema::TYPE_INTEGER,
            'updated_at'=> Schema::TYPE_INTEGER,
            'created_by'=> Schema::TYPE_INTEGER,
            'updated_by'=> Schema::TYPE_INTEGER,
        ],$tableOptions);         
    }

    public function down()
    {
        $this->dropTable('param_names');
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
