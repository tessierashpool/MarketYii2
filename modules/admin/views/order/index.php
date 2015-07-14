<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\utilities\UnixDateRangePicker;
use app\models\Status;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            //'user_id',
            //'first_name',
            //'last_name',
            //'state',
            // 'city',
            // 'adress',
            
            // 'email:email',
            // 'delivery_id',
            // 'delivery_price',
            // 'payment_id',
            // 'total_price',
            [
                'label' => 'User',
                'format' => 'html',
                'attribute'=>'fullname',
                'value' => function ($model) {
                    return $model->fullName;
                }
            ],   
            [
                'label' => 'Shipping address',
                'format' => 'html',
                'attribute'=>'s_address',
                'value' => function ($model) {
                    return $model->fullAdress;
                }
            ],  
            'telephone',            
            [
                'label' => 'Details',
                'format' => 'raw',
                'value' => function ($model) {
                    foreach ($model->items as $item) {
                        $result .= $item->fullDetails ."\n\n";
                    }
                    return $result;
                }
            ],  
            'total_price',                   
            [
                'attribute'=>'status',
                'filter'=>Status::getList(),
                'value' => function ($model){
                    return Status::getList()[$model->status];
                }
            ],
            [
                'label' => 'Created at',
                'format' => ['date','dd.MM.yyyy HH:mm'],
                'attribute' => 'created_at' ,
                'filter' => UnixDateRangePicker::widget([
                    'name'=>'created_at',
                    'convertFormat'=>true,
                    'hideInput'=>true,
                    'language'=>'ru',
                    'pluginOptions'=>[
                        'format'=>'d.m.Y H:i',
                        'timePicker'=>true,
                        'timePickerIncrement'=>5,  
                        'timePicker12Hour'=>false,                      
                        'separator'=>' - ',
                        'opens'=>'left'
                    ],              
                ])
            ],
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn','template' => '{view}',],
        ],
    ]); ?>

</div>
