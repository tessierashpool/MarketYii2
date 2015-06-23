<?php

namespace app\models;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use Yii;

class Cart extends Model
{
    public static function setCart($id,$scode,$sname){
        $cookies = Yii::$app->request->cookies;
        $quantity = 1;
        $cart = [];
        if($cookies->has('cart'))
        {
            $cart = $cookies['cart']->value;
            $new = true;
            foreach ($cart as $key => $value) {
                if($value['id']==$id&&$value['scode']==$scode)
                {
                    $quantity = $cart[$key]['quantity'] = $value['quantity']+1;
                    $new = false;
                    break;
                }
            }
            if($new)
                $cart[]=['id'=>$id,'scode'=>$scode,'sname'=>$sname,'quantity'=>$quantity];
            Yii::$app->response->cookies->add(new \yii\web\Cookie(['name' => 'cart','value' => $cart,'expire'=>time() + 86400 * 30]));             
        }
        else
        {
            $cart[]=['id'=>$id,'scode'=>$scode,'sname'=>$sname,'quantity'=>$quantity];
            Yii::$app->response->cookies->add(new \yii\web\Cookie(['name' => 'cart','value' => $cart,'expire'=>time() + 86400 * 30]));           
        }
        return $quantity;         
    }  

    public static function getCart(){ 
        $cookies = Yii::$app->request->cookies;
        $cart = [];
        if($cookies->has('cart'))
        {
            $cart = $cookies['cart']->value;          
        }    
        return $cart;   
    }  

    public static function responseCount(){ 
        $cookies = Yii::$app->response->cookies;
        $cart = [];
        if($cookies->has('cart'))
        {
            $cart = $cookies['cart']->value;          
        }         
        return count($cart);   
    }  

    public static function count(){ 
        $cookies = Yii::$app->response->cookies;
        $cart = [];
        if($cookies->has('cart'))
        {
            $cart = $cookies['cart']->value;          
        }         
        return count(self::getCart());   
    }    

    public static function cartLight(){
        $cookies = Yii::$app->request->cookies;
        $cartLightHtml = '';
        if($cookies->has('cart'))
        {
            $cart = $cookies['cart']->value; 
            $cartCount =count($cart);    
            if($cartCount>0)  
                $cartLightHtml = '<span>'.$cartCount.'</span>';
        }  
        return $cartLightHtml;      
    }   

    public static function deleteItem($id,$scode){ 
        $cookies = Yii::$app->request->cookies;
        $cart = [];
        if($cookies->has('cart'))
        {
            $cart = $cookies['cart']->value;
            $new = true;
            foreach ($cart as $key => $value) {
                if($value['id']==$id&&$value['scode']==$scode)
                {
                    unset($cart[$key]);
                    break;
                }
            }
            Yii::$app->response->cookies->add(new \yii\web\Cookie(['name' => 'cart','value' => $cart,'expire'=>time() + 86400 * 30]));             
        }
    }  
    public static function clearCart(){ 
        $cookies = Yii::$app->response->cookies;
        $cookies->remove('cart');
    }       
}