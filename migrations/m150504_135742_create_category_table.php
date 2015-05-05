<?php

use yii\db\Schema;
use yii\db\Migration;

class m150504_135742_create_category_table extends Migration
{
    public function up()
    {
        $this->createTable('categories', [
            'id' => 'pk',
            'code' => Schema::TYPE_STRING." UNIQUE" ,
            'name'=> Schema::TYPE_STRING,
            'description'=> Schema::TYPE_STRING,
            'parent_id'=> Schema::TYPE_INTEGER,
            'depth'=> Schema::TYPE_INTEGER,
            'created_at'=> Schema::TYPE_INTEGER,
            'updated_at'=> Schema::TYPE_INTEGER,
            'created_by'=> Schema::TYPE_INTEGER,
            'updated_by'=> Schema::TYPE_INTEGER,
        ]);  
    }

    public function down()
    {
        $this->dropTable('categories');
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
