<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\user\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
				'class' => 'yii\grid\SerialColumn',
				'contentOptions'=>['style'=>'width: 30px;']			
			],
			[
				'label' => 'Id',
				'format' => 'raw',
				'attribute' => 'id',
				'contentOptions'=>['style'=>'width: 100px;']
			],
            'username',
            [
				'class' => 'app\utilities\AdminActionColumn',
				'contentOptions'=>['style'=>'max-width: 30px;']
			],
        ],
    ]); ?>

</div>
