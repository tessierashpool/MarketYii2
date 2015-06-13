<?php

namespace app\models;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use Yii;

class Statistic extends Model
{
    //Increment parameter value count in category
    public function plusParameter()
    {
        $model = SParametersInCategory::find()->where(['id_category'=>2,'parameter_value'=>'aaa'])->one(); 
        if($model instanceof  yii\db\ActiveRecord)
        {
            //$model->count = $model->count + 1;
            $model->updateCounters(['count'=>'1']);
            $model->save();
        }
        else
        {
            $model = new SParametersInCategory();
            $model->id_category = 2;
            $model->parameter_value = 'aaa';
            $model->count = 1;
            $model->save();
        }
    }   
    //Dicrement parameter value count in category
    public function minusParameter()
    {

        $model = SParametersInCategory::find()->where(['id_category'=>2,'parameter_value'=>'aaa'])->one(); 
        if($model instanceof  yii\db\ActiveRecord)
        {
            $model->updateCounters(['count'=>'-1']);
            $model->save();
        }
        else
        {
            $model = new SParametersInCategory();
            $model->id_category = 2;
            $model->parameter_value = 'aaa';
            $model->count = 0;
            $model->save();
        }
    }  

    public static function getAllParametersValuesInCategory($category_id=[]){
        //return ItemsParametersValue::find()->joinWith('items')->select(['count(*)','parameter_id','value'])->groupBy('value')->where(['items.active'=>1])->andFilterWhere(['items.category_id'=>$category_id])->asArray()->all();
        //return ItemsParametersValue::tableName();
        if(count($category_id)>0)
        {
            $strCat = implode(',',$category_id);
            return Yii::$app->db->createCommand(
                'SELECT count(*), `parameter_id`, `value` 
                FROM `i_parameters_search` 
                LEFT JOIN `items` 
                ON `i_parameters_search`.`item_id` = `items`.`id` 
                WHERE (`items`.`active`=1) 
                AND (`items`.`category_id` IN ('.$strCat.')) 
                GROUP BY `value`')->queryAll();
        }
        else
        {
            return Yii::$app->db->createCommand(
                'SELECT count(*), `parameter_id`, `value` 
                FROM `i_parameters_search` 
                LEFT JOIN `items` 
                ON `i_parameters_search`.`item_id` = `items`.`id` 
                WHERE `items`.`active`=1 
                GROUP BY `value`')->queryAll();     
        }
        //return Yii::$app->db->createCommand('SELECT count(*), `parameter_id`, `value` FROM `items_parameters_value` LEFT JOIN `items` ON `items_parameters_value`.`item_id` = `items`.`id` WHERE (`items`.`active`=1) AND (`items`.`category_id` IN (3,4)) GROUP BY `value`')->queryAll();
        //SELECT max(id) from `items_parameters_value`
        //SELECT  max( id ) + (SELECT max( id ) FROM `lists_to_parameters` ) FROM `items_parameters_value` 
    }   

    public static function getAllItemsPriceRange($category_id=[]){
        if(count($category_id)>0)
        {
            $strCat = implode(',',$category_id);
            return Yii::$app->db->createCommand('SELECT  min(price) as min,max(price) as max FROM `items` WHERE (`items`.`active`=1) AND (`items`.`category_id` IN ('.$strCat.'))')->queryOne();
        }           
        else
        {
            return Yii::$app->db->createCommand('SELECT  min(price) as min,max(price) as max FROM `items` WHERE `items`.`active`=1')->queryOne();            
        }            
    }    
}