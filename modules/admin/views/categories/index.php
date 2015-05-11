<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\widgets\tree\CategoryTreeWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories(tree)');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="categories-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Category'), ['create'], ['class' => 'btn btn-success']) ?>
        <?//= Html::a(Yii::t('app', 'Create Category in Table'), ['create-table'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=CategoryTreeWidget::widget(['category'=>$dataTree]);?>
</div>
