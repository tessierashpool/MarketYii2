<?php
use app\models\Items;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */


$this->title = "Order №".$model->id;
$this->params['breadcrumbs'][] = $this->title;
$cart = $model->items;
?> 
<div class="row cart-content">
    <div class="col-xs-12 ">
        <h2 class="custom-h2"><?=$this->title?></h2>
        <?php if (Yii::$app->session->hasFlash('newOrder')): ?>
            <div class="alert alert-success" role="alert">Thank you for your order</div>
        <?php endif; ?>
        <p>Order date - <?=date('d.m.Y', $model->created_at)?></p> 
        <p>Order status - <?=$model->status?></p>         
        <p>Order details </p>  
        <table class="table hidden-xs">
            <tr>
                <td style="position: relative;">
                    ITEM
                </td>
                <td width="100px">QUANITY</td>
                <td >PRICE</td>
                <td width="20px"></td>
            </tr>            
            <?foreach ($cart as $key => $value):?>  
                <?$item = Items::findOne($value['item_id'])?> 
                <tr >
                    <td >
                        <div class="row">
                            <div class="col-xs-4">
                                <img src="<?=$item->getImage()->getUrl('260x')?>" class="img-responsive cart-img" alt="Responsive image">
                            </div>
                            
                                <p><a href="<?=Url::to(['detail', 'id' => $item->id]);?>"><?=$value['item_name'];?></a></p>
                                <p>Size: <?=$value['item_size']?></p>
                                                                        
                        </div>
                    </td>
                    <td width="100px">
                         <?=$value['item_quantity']?>                                       
                    </td>
                    <td >
                        <span class="total-item-price "><?=$value['item_price']*$value['item_quantity']?></span>р
                    </td>
                    <td ></td>
                </tr>                                                   
            <?endforeach;?>                                         
            <tr>
                <td>TOTAL PRICE</td>
                <td ></td>
                <td ><span class="total-cart-price"><?=$model->total_price?></span>р</td>
                <td ></td>
            </tr>             
        </table> 
        <table class="table hidden-lg hidden-md hidden-sm">
            <tr>
                <td style="position: relative;">
                    Order
                </td>
            </tr>  
            <?foreach ($cart as $key => $value):?>  
                <?$item = Items::findOne($value['id'])?>
                <tr >
                    <td >
                        <div class="row">
                            <div class="col-xs-4">
                                <img src="<?=$item->getImage()->getUrl('260x')?>" class="img-responsive cart-img" alt="Responsive image">
                            </div>
                            <div class="col-xs-8">
                                <p><a href="<?=Url::to(['detail', 'id' => $item->id]);?>"><?=$value['item_name'];?></a></p>
                                <p>Size:<?=$value['item_size']?></p>                                
                                <p>Price: <span class="item-price-cont"><span class="item-price"><?=$value['item_price']?></span>p</span></p>
                                <p>Quantity: <?=$value['item_quantity']?></p>  
                                <p>Total price: <span class="item-price-cont"><span class="total-item-price "><?=$value['item_price']*$value['item_quantity']?></span>p</span></p>
                            </div>      
                        </div>
                    </td>
                </tr>                 
            <?endforeach;?>                                                                          
            <tr class="tr-cart-item">
                <td>TOTAL CART PRICE: <span class="item-price-cont"> <span class="total-cart-price"><?=$model->total_price?></span>p </span></td>
            </tr>            
        </table>                                                           
    </div>                      
</div>                      