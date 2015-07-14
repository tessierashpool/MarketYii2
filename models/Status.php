<?php

namespace app\models;

use yii\base\Model;
use Yii;

class Status extends Model
{
    public static $default = 'processed';
    public static function getList()
    {
        $list['processed'] = 'Processed';
        $list['pending'] = 'Pending';
        $list['delivered'] = 'Delivered';
        return $list;
    }    
}