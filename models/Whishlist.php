<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use Yii;

class Whishlist extends ActiveRecord
{

    public static function tableName()
    {
        return 'whishlist';
    } 

    public static function attachToUser(){ 
        $cookies = Yii::$app->request->cookies;
        $whishlist = [];
        if($cookies->has('whishlist'))
        {
            $whishlist = $cookies['whishlist']->value;
            foreach ($whishlist as $key => $value) {
                $dbWhishlist = self::find()->where(['user_id'=>Yii::$app->user->id,'item_id'=>$value])->one();
                if($dbWhishlist == null)
                {
                    $dbWhishlist = new Whishlist();
                    $dbWhishlist->user_id = Yii::$app->user->id;
                    $dbWhishlist->item_id = $value;
                    $dbWhishlist->save();
                }
            
            }
            $cookies = Yii::$app->response->cookies;
            $cookies->remove('whishlist');        
        }         
    } 

    public static function addToWhishlist($id){
        $cookies = Yii::$app->request->cookies;
        $whishlist = [];
        if(Yii::$app->user->isGuest)
        {        
            if($cookies->has('whishlist'))
            {
                $whishlist = $cookies['whishlist']->value;
                $whishlist[$id]= $id;
                Yii::$app->response->cookies->add(new \yii\web\Cookie(['name' => 'whishlist','value' => $whishlist,'expire'=>time() + 86400 * 30]));             
                return count($whishlist);
            }
            else
            {
                $whishlist[$id]= $id;
                Yii::$app->response->cookies->add(new \yii\web\Cookie(['name' => 'whishlist','value' => $whishlist,'expire'=>time() + 86400 * 30]));           
                return count($whishlist);
            }    
        }
        else
        {
            $dbWhishlist = self::find()->where(['user_id'=>Yii::$app->user->id,'item_id'=>$id])->one();
            if($dbWhishlist == null)
            {
                $dbWhishlist = new Whishlist();
                $dbWhishlist->user_id = Yii::$app->user->id;
                $dbWhishlist->item_id = $id;
                $dbWhishlist->save();
                return self::find()->where(['user_id'=>Yii::$app->user->id])->count();
            }              
        }   
    }      

    public static function removeFromWhishlist($id){
        $cookies = Yii::$app->request->cookies;
        $whishlist = [];
        if(Yii::$app->user->isGuest)
        {        
            if($cookies->has('whishlist'))
            {
                $whishlist = $cookies['whishlist']->value;
                unset($whishlist[$id]);
                Yii::$app->response->cookies->add(new \yii\web\Cookie(['name' => 'whishlist','value' => $whishlist,'expire'=>time() + 86400 * 30]));             
                return count($whishlist);
            }
        }
        else
        {
            $dbWhishlist = self::find()->where(['user_id'=>Yii::$app->user->id,'item_id'=>$id])->one();
            $dbWhishlist->delete(); 
            return self::find()->where(['user_id'=>Yii::$app->user->id])->count();           
        }      
    } 

    public static function getWhishlist(){
        $cookies = Yii::$app->request->cookies;
        $whishlist = [];
        if(Yii::$app->user->isGuest)
        {         
            if($cookies->has('whishlist'))
            {
                $whishlist = $cookies['whishlist']->value;                       
            }  
        }
        else
        {
            $whishlist = ArrayHelper::map(self::find()->select('item_id AS id')->where(['user_id'=>Yii::$app->user->id])->asArray()->all(),'id','id');
        }
        return $whishlist;    
    } 

    public static function whishlistLight(){
        $cookies = Yii::$app->request->cookies;
        $whishlistLightHtml = '';
        if(Yii::$app->user->isGuest)
        {          
            if($cookies->has('whishlist'))
            {
                $whishlist = $cookies['whishlist']->value; 
                $whishlistCount =count($whishlist);    
                if($whishlistCount>0)  
                    $whishlistLightHtml = '<span>'.$whishlistCount.'</span>';
            }
        }  
        else
        {
            if(($whishlistCount=count(self::getWhishlist()))>0)  
                $whishlistLightHtml = '<span>'.$whishlistCount.'</span>';            
        }
        return $whishlistLightHtml;      
    }    

    public static function dataProvider()
    {
        $query = Items::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ]            
        ]);

        $arWhishlist = self::getWhishlist();

        if(count($arWhishlist)<1)
            $query->where('0=1');

        $query->orFilterWhere([
            'id' => $arWhishlist,
        ]);

        return $dataProvider;
    }           
}