<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

global $roles_descrition_arr ;
$roles_descrition_arr  = $model->rolesDescriptionsArray;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?//= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>
	<?if($model->id!=1):?>
		<div class="row">
			<div class="col-xs-12">
				<h3  ><?=Yii::t('yiimarket','Assigned Roles')?></h3>
					<ul class="list-group  ">
						<?=Html::checkboxList('authRoles',$model->assignmentsArray, $model->rolesArray ,['item'=>function ($index, $label, $name, $checked, $value){
							global $roles_descrition_arr;
							return '<li class="list-group-item">'.Html::checkbox('authRoles['.$value.']', $checked,['label'=>$label,'value'=>$value ]).'<blockquote style="font-weight:100;font-size:12px">
							<p>'.$roles_descrition_arr[$value].'</p>
							</blockquote></li>';		
						}])?>
					</ul>
			</div>				
		</div>	
		<br />
	<?endif;?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
