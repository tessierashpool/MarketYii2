<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

global $roles_descrition_arr, $permissions_descrition_arr;
$roles_descrition_arr  = $model->rolesDescriptionsArray;
$permissions_descrition_arr  = $model->permissionsDescriptionsArray;

/* @var $this yii\web\View */
/* @var $model app\models\AuthItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Auth Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            ['label'=>'Type', 'value'=>$model->roles[$model->type]],
            'description:ntext',
            'created_at:date',
            'updated_at:date',
        ],
    ]) ?>

	<div class="row">
        <div <?if($model->type==2)echo "style='display:none'"?> class="col-xs-6">
            <h3 ><?=Yii::t('yiimarket','Assigned Roles')?></h3>
			<?=Html::ul(array_intersect($model->assignmentsArray, $model->rolesArray),['class'=>'list-group','itemOptions'=>['class'=>'list-group-item']]);?>
        </div>	
        <div class="col-xs-6">
            <h3 ><?=Yii::t('yiimarket','Assigned Permissions')?></h3>
			<?=Html::ul(array_intersect($model->assignmentsArray, $model->permissionsArray),['class'=>'list-group','itemOptions'=>['class'=>'list-group-item']]);?>
        </div>			
	</div>	<br />	

</div>
