<?php

use yii\db\Schema;
use yii\db\Migration;

class m150530_142836_costa_rico extends Migration
{
    public function up()
    {
        $this->createTable('image', [
            'id' => 'pk',
            'filePath' => 'VARCHAR(400) NOT NULL',
            'itemId' => 'int(20) NOT NULL',
            'isMain' => 'int(1)',
            'modelName' => 'VARCHAR(150) NOT NULL',
            'urlAlias' => 'VARCHAR(400) NOT NULL',
        ]);
    }

    public function down()
    {
        echo "m150530_142836_costa_rico cannot be reverted.\n";

        return false;
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
