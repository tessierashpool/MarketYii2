<?php

use yii\helpers\Html;
use yii\helpers\Url;


$this->title = Yii::t('app', 'Fixtures');
?>
<h1><?= Html::encode($this->title) ?></h1>
<br>
<div class="items-index">
    <p><a type="button" href="<?= Url::to(['create-parameters']);?>" class="btn btn-success">Create parameters</a></p>
    <p><a type="button" href="<?= Url::to(['create-categories']);?>" class="btn btn-warning">Create categories(use after creating Parameters)</a></p>
    <p><a type="button" href="<?= Url::to(['create-items']);?>" class="btn btn-warning">Create Items(use after creating categories)</a></p>
    <p><a data-confirm="Are you realy want to truncate tables?" href="<?= Url::to(['truncate-items']);?>" type="button" class="btn btn-danger">Clear items table</a></p>
    <p><a data-confirm="Are you realy want to truncate tables?" href="<?= Url::to(['truncate-all']);?>" type="button" class="btn btn-danger">Clear parameters, categories and items tables</a></p>
    <pre>
        <?//print_r($model->parameters)?>
    </pre>

</div>
