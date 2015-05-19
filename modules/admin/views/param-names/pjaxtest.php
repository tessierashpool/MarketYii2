<?php

use yii\helpers\Html;
use yii\grid\GridView;

?>
<?php \yii\widgets\Pjax::begin(['timeout' => '0']); ?>
<?= Html::a("Refresh", ['pjaxtest'], ['class' => 'btn btn-lg btn-primary']);?>
<h1>Current time: <?= $time ?></h1>
<?php \yii\widgets\Pjax::end(); ?>