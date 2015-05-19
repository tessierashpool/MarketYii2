<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\widgets\tree\CategoryTreeWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=CategoryTreeWidget::widget([
        'category'=>$dataTree,
        'actionView'=>false,
        'actionUpdate'=>false,
        'actionDelete'=>false,
        'actionOrder'=>false,
        'actionCreate'=>false,
    ]);?>

</div>
