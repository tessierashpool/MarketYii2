<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/*
$rbac = Yii::$app->authManager;
$roles = $rbac->getRoles();
var_dump($roles['']);*/
global $roles_descrition_arr, $permissions_descrition_arr;
$roles_descrition_arr  = $model->rolesDescriptionsArray;
$permissions_descrition_arr  = $model->permissionsDescriptionsArray;

/* @var $this yii\web\View */
/* @var $model app\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'type')->dropDownList($model->roles,['onchange'=>'if($(this).val()==1){$("#rolesCont").show()}else{$("#rolesCont").hide()};']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
	
	<div class="row">
        <div id="rolesCont" class="col-xs-6">
            <h3 class="text-center"><?=Yii::t('yiimarket','Assigned Roles')?></h3>
        		<ul class="list-group  ">
					<?=Html::checkboxList('authRoles',$model->assignmentsArray, $model->rolesArray ,['item'=>function ($index, $label, $name, $checked, $value){
						global $roles_descrition_arr;
						return '<li class="list-group-item">'.Html::checkbox('authRoles['.$value.']', $checked,['label'=>$label,'value'=>$value ]).'<blockquote style="font-weight:100;font-size:12px">
						<p>'.$roles_descrition_arr[$value].'</p>
						</blockquote></li>';		
					}])?>
                </ul>
        </div>	
        <div class="col-xs-6">
            <h3 class="text-center"><?=Yii::t('yiimarket','Assigned Permissions')?></h3>
        		<ul class="list-group  ">
					<?=Html::checkboxList('authPermissions',$model->assignmentsArray, $model->permissionsArray,['item'=>function ($index, $label, $name, $checked, $value){
						global $permissions_descrition_arr;
						return '<li class="list-group-item">'.Html::checkbox('authPermissions['.$value.']', $checked,['label'=>$label, 'value'=>$value]).'<blockquote style="font-weight:100;font-size:12px">
						<p>'.$permissions_descrition_arr[$value].'</p>
						</blockquote></li>';		
					}])?>
                </ul>
        </div>			
	</div>	<br />
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
