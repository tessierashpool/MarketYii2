<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
$this->registerJs("
$(function () {
  $('[data-toggle=\'tooltip\']').tooltip()
})
    ",\yii\web\View::POS_BEGIN);

$this->title = "My orders";
$this->params['breadcrumbs'][] = $this->title;
$orders = $dataProvider->getModels();
?>    
<div class="row checkout-content">
    <div class="col-xs-12">
        <h2 class="custom-h2"><?=$this->title?></h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>   
            <?foreach ($orders as $order):?>      
                <tr>
                    <td><?=$order->id?></td>
                    <td><?=date('d.m.Y',$order->created_at)?></td>
                    <td><?=$order->status?></td>
                    <td><a data-toggle="tooltip" data-placement="left" title="Order details" href="<?=Url::to(['order','id'=>$order->id])?>"><i class="glyphicon glyphicon-list-alt"></i></a></td>
                </tr>
            <?endforeach;?>           
        </table>
        <div class="nav-cont text-center">
            <?=LinkPager::widget(['pagination' => $dataProvider->pagination,'maxButtonCount'=>6]);?>                             
        </div>         
    </div>                              
</div>                      