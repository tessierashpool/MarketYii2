<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use Yii;

class Cart extends ActiveRecord
{
    public static function tableName()
    {
        return 'cart';
    } 

    public static function attachToUser(){ 
        $cookies = Yii::$app->request->cookies;
        if($cookies->has('cart'))
        {
            $cart = $cookies['cart']->value;
            foreach ($cart as $key => $value) {
                $userCart = self::find()->where(['user_id'=>Yii::$app->user->id,'item_id'=>$value['id'],'scode'=>$value['scode']])->one();
                if($userCart !== null)
                {
                    $userCart->quantity = $userCart->quantity + $value['quantity'];
                    $userCart->save();
                }
                else
                {
                    $userCart = new Cart();
                    $userCart->user_id = Yii::$app->user->id;
                    $userCart->item_id = $value['id'];
                    $userCart->scode = $value['scode'];
                    $userCart->sname = $value['sname'];
                    $userCart->quantity = $value['quantity'];
                    $userCart->save();
                }
            
            }
            $cookies = Yii::$app->response->cookies;
            $cookies->remove('cart');         
        }         
    } 

    public static function setCart($id,$scode,$sname){
        $cookies = Yii::$app->request->cookies;
        $quantity = 1;
        $cart = [];
        if(Yii::$app->user->isGuest)
        {
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
        }
        else
        {
            $userCart = self::find()->where(['user_id'=>Yii::$app->user->id,'item_id'=>$id,'scode'=>$scode])->one();
            if($userCart !== null)
            {
                $quantity = $userCart->quantity = $userCart->quantity + 1;
                $userCart->save();
            }
            else
            {
                $userCart = new Cart();
                $userCart->user_id = Yii::$app->user->id;
                $userCart->item_id = $id;
                $userCart->scode = $scode;
                $userCart->sname = $sname;
                $quantity = $userCart->quantity = 1;
                $userCart->save();
            }            
        }
        return $quantity;         
    }  

    public static function changeQuantity($id,$scode,$quantity){
        $cookies = Yii::$app->request->cookies;
        $cart = [];       
        if(Yii::$app->user->isGuest)
        { 
            if($cookies->has('cart'))
            {
                $cart = $cookies['cart']->value;
                foreach ($cart as $key => $value) {
                    if($value['id']==$id&&$value['scode']==$scode)
                    {
                        $quantity = $cart[$key]['quantity'] = $quantity;
                        break;
                    }
                }
                Yii::$app->response->cookies->add(new \yii\web\Cookie(['name' => 'cart','value' => $cart,'expire'=>time() + 86400 * 30]));  
            } 
        }
        else
        {
            $userCart = self::find()->where(['user_id'=>Yii::$app->user->id,'item_id'=>$id,'scode'=>$scode])->one();
            if($userCart !== null)
            {
                $userCart->quantity = $quantity;
                $userCart->save();
            }              
        }
    }

    public static function getCart(){ 
        $cookies = Yii::$app->request->cookies;
        $cart = [];
        if(Yii::$app->user->isGuest)
        {
            if($cookies->has('cart'))
            {
                $cart = $cookies['cart']->value;          
            }  
        } 
        else
        {
            $cart = self::find()->select('item_id AS id, scode, sname, quantity')->where(['user_id'=>Yii::$app->user->id])->asArray()->all();
        } 
        return $cart;   
    }  

    public static function responseCount(){ 
        $cookies = Yii::$app->response->cookies;
        $cart = [];
        $count = 0;
        if(Yii::$app->user->isGuest)
        {
            if($cookies->has('cart'))
            {
                $cart = $cookies['cart']->value;
                foreach ($cart as $key => $value) {
                    $count += $value['quantity'];
                }      
            }  
        }
        else
        {
            $count = self::find()->select('quantity')->where(['user_id'=>Yii::$app->user->id])->sum('quantity');
        }           
        return $count;   
    }  

    public static function count(){ 
        $cookies = Yii::$app->request->cookies;
        $cart = [];
        $count = 0;
        if(Yii::$app->user->isGuest)
        {
            if($cookies->has('cart'))
            {
                $cart = $cookies['cart']->value;
                foreach ($cart as $key => $value) {
                    $count += $value['quantity'];
                }      
            }  
        }
        else
        {
            $count = self::find()->select('quantity')->where(['user_id'=>Yii::$app->user->id])->sum('quantity');
        }         
        return $count;   
    }    

    public static function cartLight(){
        $cartLightHtml = ''; 
        $cartCount = self::count();  
        if($cartCount>0)  
                $cartLightHtml = '<span>'.$cartCount.'</span>';
 
        return $cartLightHtml;      
    }   

    public static function deleteItem($id,$scode){ 
        $cookies = Yii::$app->request->cookies;
        $cart = [];
        if(Yii::$app->user->isGuest)
        {
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
        else
        {
            $userCart = self::find()->where(['user_id'=>Yii::$app->user->id,'item_id'=>$id,'scode'=>$scode])->one();
            if($userCart !== null)
            {
                $userCart->delete();
            }            
        }    
    }  
    public static function clearCart(){ 
        if(Yii::$app->user->isGuest)
        {
            $cookies = Yii::$app->response->cookies;
            $cookies->remove('cart');
        }
        else
        {
            self::deleteAll('user_id = '.Yii::$app->user->id);
        }
    }       
}