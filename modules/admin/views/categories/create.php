<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Categories */
$parent = $model->findOne($this->params['customParam']['parent'])->name;
$this->title = Yii::t('app', 'Create Categories');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?if($this->params['customParam']['parent']>0)echo '<p>'.Yii::t('app', 'Parent').' "'.$parent.'"</p>';?>
	
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
