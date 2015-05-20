<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Items */

$this->title = Yii::t('app', 'Create Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Category Select'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $categoryModel->name, 'url' => ['list','category_id'=>$categoryModel->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categoryModel' => $categoryModel,
    ]) ?>

</div>
