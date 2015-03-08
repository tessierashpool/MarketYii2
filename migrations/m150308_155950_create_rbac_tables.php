<?php

use yii\db\Schema;
use yii\db\Migration;

class m150308_155950_create_rbac_tables extends Migration
{
    public function up()
    {
		$this->execute(file_get_contents(Yii::getAlias('@yii/rbac/migrations/schema-mysql.sql')));
		
		$rbac = Yii::$app->authManager;
		$admin = $rbac->createRole('admin');
		$admin->description = 'Admin';
		$rbac->add($admin);	

		$adminPanel = $rbac->createPermission('admin_panel');
		$adminPanel->description = 'Admin panel access';
		$rbac->add($adminPanel);	
		
		$rbac->addChild($admin, $adminPanel);
		$rbac->assign($admin, 1);		
    }

    public function down()
    {
		$this->dropTable('auth_assignment');
		$this->dropTable('auth_item_child');		
		$this->dropTable('auth_item');
		$this->dropTable('auth_rule');
    }
}
