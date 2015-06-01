<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\utilities\UnixDateRangePicker;
use app\widgets\gridAllButton\GridAllButton;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $categoryModel->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Category Select'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Items'), ['create','category_id'=>$categoryModel->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id'=> 'grid',
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            [
                'label' => 'Id',
                'format' => 'raw',
                'attribute' => 'id',
                'contentOptions'=>['style'=>'width: 70px;']
            ],
            [
                'attribute'=>'images',
                'value'=>function($searchModel){return Html::img($searchModel->getImage()->getUrl('120x'));},
                'format' => 'html',
                'contentOptions'=>['style'=>'width: 137px;']
            ],
            'name',
            'description',
            'price',
            [
                'label' => 'Created at',
                'format' => ['date','dd.MM.yyyy'],
                'attribute' => 'created_at' ,
                'filter' => UnixDateRangePicker::widget([
                    'name'=>'created_at',
                    'convertFormat'=>true,
                    'hideInput'=>true,
                    'language'=>'ru',
                    'pluginOptions'=>[
                        'format'=>'d.m.Y',
                        'separator'=>' - ',
                        'opens'=>'left'
                    ],              
                ])
            ],            
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    //view button
                    'update' => function ($url, $model) {
                        return Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['update','id'=>$model->id,'category_id'=>$model->category_id], [
                                    'title' => Yii::t('app', 'View'),                                 
                        ]);
                    },
                ]
            ],
        ],
    ]); ?>
    <?=GridAllButton::widget();?>
</div>
