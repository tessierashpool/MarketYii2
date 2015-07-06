<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
use Yii;

class Account extends User
{	
    public function rules()
    {
        return [
			[['email', 'first_name', 'last_name','state','city','adress','telephone'], 'string', 'max' => 255],	
            [['email'], 'email'],
            [['email'], 'required']	
        ];
    }	
}
