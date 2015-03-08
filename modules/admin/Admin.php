<?php

namespace app\modules\admin;

class Admin extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\admin\controllers';
	//public $layoutPath = 'modules/admin/views/layouts';
    //public $layout = 'main';
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
	
	public function behaviors()
	{
		return [
			'access' => [ 
				'class' => \yii\filters\AccessControl::className(), 
				'rules' => [
					[
					'roles' => ['admin_panel'], 
					'allow' => true, 
					]
				]
			]
		];
	}	
}
