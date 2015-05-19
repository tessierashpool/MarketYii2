<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ParamNames */

$this->title = Yii::t('app', 'Create New Parameter');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parameters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="param-names-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
