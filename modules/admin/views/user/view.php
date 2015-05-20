<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?
			if($model->id!=1)
				echo Html::a('Delete', ['delete', 'id' => $model->id], [
					'class' => 'btn btn-danger',
					'enable'=>false,
					'data' => [
						'confirm' => 'Are you sure you want to delete this item?',
						'method' => 'post',
					],
				]) 
		?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
        ],
    ]) ?>
	<div class="row">
        <div class="col-xs-6">
            <h3 ><?=Yii::t('yiimarket','Assigned Roles')?></h3>
			<?=Html::ul(array_intersect($model->assignmentsArray, $model->rolesArray),['class'=>'list-group','itemOptions'=>['class'=>'list-group-item']]);?>
        </div>		
        <div class="col-xs-6">
            <h3 ><?=Yii::t('yiimarket','Permissions')?></h3>
			<?=Html::ul($model->permissionsArray,['class'=>'list-group','itemOptions'=>['class'=>'list-group-item']]);?>
        </div>		
	</div>	
</div>
