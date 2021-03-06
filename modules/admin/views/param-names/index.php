<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\utilities\UnixDateRangePicker;
use yii\helpers\Url;
use app\widgets\gridAllButton\GridAllButton;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ParamNamesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Parameters');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="param-names-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create New Parameter'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \yii\widgets\Pjax::begin(['timeout' => '0']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id'=> 'grid',
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],

            'id',
            'code',
            'name',
            [
                'attribute'=>'category_id', 
                'value'=>function($searchModel){return $searchModel->categoriesList[$searchModel->category_id];},
                'filter'=>$searchModel->categoriesList
            ],

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
            ] ,          
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
    <?=GridAllButton::widget();?>
</div>
