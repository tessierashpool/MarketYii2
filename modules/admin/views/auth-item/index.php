<?php

use yii\helpers\Html;
use yii\grid\GridView;
//use dosamigos\datepicker\DatePicker;
use kartik\daterange\DateRangePicker;
use app\utilities\UnixDateRangePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Auth Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Auth Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
			[
				'label' => 'Type',
				//'class' => 'app\utilities\formatters\AuthItemsColumn',
				'attribute' => 'type',	
				'value' => function ($searchModel) {
					$roles = $searchModel->roles;
					return $roles[$searchModel->type];
				},
				'filter' =>$searchModel->roles
			],
            'description:ntext',
            //'rule_name',
            //'data:ntext',
			[
				'label' => 'Created at',
				'format' => ['date','dd.MM.yyyy'],
				'attribute' => 'created_at'	,
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
			[
				'label' => 'Updated at',
				'format' => ['date','dd.MM.yyyy'],
				'attribute' => 'updated_at'	,
				'filter' => UnixDateRangePicker::widget([
					'name'=>'updated_at',
					'convertFormat'=>true,
					'language'=>'ru',
					'hideInput'=>true,
					'pluginOptions'=>[
						'format'=>'d.m.Y',
						'separator'=>' - ',
						'opens'=>'left',
					]
				])
			],

            ['class' => 'app\utilities\RolesActionColumn'],
        ],
    ]); ?>

</div>
