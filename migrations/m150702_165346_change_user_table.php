<?php

use yii\db\Schema;
use yii\db\Migration;

class m150702_165346_change_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'email', Schema::TYPE_STRING);
        $this->addColumn('user', 'first_name', Schema::TYPE_STRING);
        $this->addColumn('user', 'last_name', Schema::TYPE_STRING);
        $this->addColumn('user', 'state', Schema::TYPE_STRING);
        $this->addColumn('user', 'city', Schema::TYPE_STRING);
        $this->addColumn('user', 'adress', Schema::TYPE_STRING);
        $this->addColumn('user', 'telephone', Schema::TYPE_STRING);
        $this->addColumn('user', 'confirmed', Schema::TYPE_BOOLEAN);
        $this->addColumn('user', 'active', Schema::TYPE_BOOLEAN);
        $this->addColumn('user', 'created_at', Schema::TYPE_INTEGER);
        $this->addColumn('user', 'updated_at', Schema::TYPE_INTEGER);
        $this->addColumn('user', 'created_by', Schema::TYPE_INTEGER);
        $this->addColumn('user', 'updated_by', Schema::TYPE_INTEGER);

        $this->createTable('email_confirm', [
            'id' => 'pk',
            'user_id' => Schema::TYPE_INTEGER ,
            'confirm_hash' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER
        ]);  

        $this->createTable('password_restore', [
            'id' => 'pk',
            'user_id' => Schema::TYPE_INTEGER ,
            'restore_hash' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER
        ]);                
    }

    public function down()
    {
        $this->dropColumn('user', 'email');
        $this->dropColumn('user', 'first_name');
        $this->dropColumn('user', 'last_name');
        $this->dropColumn('user', 'state');
        $this->dropColumn('user', 'city');
        $this->dropColumn('user', 'adress');
        $this->dropColumn('user', 'telephone');
        $this->dropColumn('user', 'confirmed');
        $this->dropColumn('user', 'active');
        $this->dropColumn('user', 'created_at');
        $this->dropColumn('user', 'updated_at');
        $this->dropColumn('user', 'created_by');
        $this->dropColumn('user', 'updated_by');

        $this->dropTable('email_confirm');
        $this->dropTable('password_restore');
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
