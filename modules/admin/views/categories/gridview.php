<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\widgets\gridAllButton\GridAllButton;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories(gridview)');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="categories-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Categories'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id'=> 'grid',
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],

            'id',
            'code',
            'name',
            'description',
            'parent_id',
            // 'depth',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?=GridAllButton::widget();?>
</div>
