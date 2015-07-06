<?php

namespace app\models;

use yii\helpers\ArrayHelper;
use Yii;

class SignUpForm extends User
{
    public $captcha;

    public function afterSave($insert,$changedAttributes)
    {
        parent::afterSave($insert,$changedAttributes);
    }

    public function rules()
    {
        return [
			[['username', 'password','email'], 'string', 'max' => 255],	
            [['username','captcha','password','email'], 'required'],
            ['captcha', 'captcha'],
            [['username'], 'unique'],       
			['email', 'email'],		
        ];
    }	
}
