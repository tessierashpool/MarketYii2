<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\utilities\UnixDateRangePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Order'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'first_name',
            'last_name',
            'state',
            // 'city',
            // 'adress',
            // 'telephone',
            // 'email:email',
            // 'delivery_id',
            // 'delivery_price',
            // 'payment_id',
            // 'total_price',
            // 'status',
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
                        'format'=>'d.m.Y ',
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
