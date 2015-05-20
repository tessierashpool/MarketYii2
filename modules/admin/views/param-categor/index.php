<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\widgets\gridAllButton\GridAllButton;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories of parameters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="param-categor-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create category of Parameters', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=> 'grid',
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],
            'id',
            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?=GridAllButton::widget();?>
</div>
