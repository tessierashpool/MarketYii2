<?php

use yii\db\Schema;
use yii\db\Migration;

class m150306_162921_create_user_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('user', [
            'id' => 'pk',
            'username' => Schema::TYPE_STRING . ' UNIQUE',
            'password' => Schema::TYPE_STRING,
			'auth_key' => Schema::TYPE_STRING . ' UNIQUE',
        ],$tableOptions);
		
        $this->insert('user', [
            'username' => "admin",
            'password' => Yii::$app->security->generatePasswordHash('admin'),
			'auth_key' => Yii::$app->security->generateRandomString(255)
        ]);		
    }

    public function down()
    {
        $this->dropTable('user');
    }
}
