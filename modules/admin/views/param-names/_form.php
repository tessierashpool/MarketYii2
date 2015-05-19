<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\ParamNames */
/* @var $form yii\widgets\ActiveForm */
?>
<script>
	 var existCode = [];
	function newValueField()
	{
		$('#new-list-code').parent().removeClass('has-error');
		$('.help-block-code-exist').addClass('hidden');	
		$('.help-block-code-empty').addClass('hidden');	
		$('#new-list-value').parent().removeClass('has-error');
		$('.help-block-value-empty').addClass('hidden');

		if($('#new-list-code').val()=='')
		{
			$('#new-list-code').parent().addClass('has-error');
			$('.help-block-code-empty').removeClass('hidden');
		}
		else if(existCode.indexOf($('#new-list-code').val())>=0)
		{
			$('#new-list-code').parent().addClass('has-error');
			$('.help-block-code-exist').removeClass('hidden');
		}
		else if($('#new-list-value').val()=='')	
		{
			$('#new-list-value').parent().addClass('has-error');
			$('.help-block-value-empty').removeClass('hidden');
		}
		else
		{
			var new_line =  '<li class="list-group-item list-value-li">';
				new_line +=	$('#new-list-value').val()+' ';		
				new_line +=	'['+$('#new-list-code').val()+']';		
				new_line +=	'<a onclick="valueFieldRemove(this,\''+$('#new-list-code').val()+'\')" href="javascript:void(0)"><i class="glyphicon glyphicon-trash"></i></a>';		
				new_line +=	'<a onclick="valueFieldUp(this)" href="javascript:void(0)"><i class="glyphicon glyphicon-arrow-up"></i></a>';
				new_line +=	'<a onclick="valueFieldDown(this)" href="javascript:void(0)"><i class="glyphicon glyphicon-arrow-down"></i></a>';
				new_line +=	'<input type="hidden" name="list-code[]" value="'+$('#new-list-code').val()+'" />';
				new_line +=	'<input type="hidden" name="list-value[]" value="'+$('#new-list-value').val()+'" />';
				new_line +=	'</li>'	;
			existCode.push($('#new-list-code').val());		
			$('#new-list-value').val('');	
			$('#new-list-code').val('');	
			$('.add-list-value-li')	.before(new_line);

			$('#value-modal').modal('hide');
		} 
	}

	function valueFieldRemove(e,code,confirm_msg)
	{	

		if(confirm_msg == null)
			confirm_msg = '<?=Yii::t('app', 'Are you sure you want to delete this item?')?>';
		if(confirm(confirm_msg))
		{	
			$(e).parent().remove();
			if(existCode.indexOf(code)>=0)
				existCode.splice(existCode.indexOf(code), 1);
		}	
	}	

    function valueFieldUp(e)
    {
        var curent_li = $(e).parent('.list-value-li');
        var prev_li = curent_li.prev('.list-value-li');
        if(prev_li.length)    
        {
            curent_li.after(prev_li);                  
        } 
    }

    function valueFieldDown(e)
    {
        var curent_li = $(e).parent('.list-value-li');
        var next_li = curent_li.next('.list-value-li');
        if(next_li.length)    
        {
            curent_li.before(next_li);                  
        } 
    } 	
</script>
<div class="param-names-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'category_id')->dropDownList($model->categoriesList) ?>

    <?= $form->field($model, 'type')->dropDownList(['list'=>Yii::t('app', 'List') ,'text'=>Yii::t('app', 'Text')],['onchange'=>'if($(this).val()=="list"){$(".values-list").removeClass("hidden")}else{$(".values-list").addClass("hidden")};']) ?>

<div class="panel panel-default values-list <?=$model->type=='text'?'hidden':'';?>" >
	<div class="panel-heading"><strong>List values</strong></div>
	<ul class="list-group ">
		<?
		if(count($model->valuesList)>0)
		{
			foreach($model->valuesList as $valueModel)
			{
				echo '<li class="list-group-item list-value-li">'.$valueModel->value.' ['.$valueModel->code.']';
				echo '<a onclick="valueFieldRemove(this,\''.$valueModel->code.'\')" href="javascript:void(0)"><i class="glyphicon glyphicon-trash"></i></a>';		
				echo '<a onclick="valueFieldUp(this)" href="javascript:void(0)"><i class="glyphicon glyphicon-arrow-up"></i></a>';
				echo '<a onclick="valueFieldDown(this)" href="javascript:void(0)"><i class="glyphicon glyphicon-arrow-down"></i></a>';
				echo '<input type="hidden" name="list-code[]" value="'.$valueModel->code.'" />';
				echo '<input type="hidden" name="list-value[]" value="'.$valueModel->value.'" />';
				echo '<script> existCode.push("'.$valueModel->code.'"); </script>';
				echo '</li>';
			}
		}
		?>
		
		<li class="list-group-item add-list-value-li">
		<?Modal::begin([
		'header' => '<h4><i class="glyphicon glyphicon-list-alt"></i> List Value</h4>',
		'footer' => '<button onclick="newValueField()" type="button" class="btn btn-primary">Add Value</button>',
		'id'=>'value-modal',
		'toggleButton' => ['tag'=>'a', 'label' => '<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add value'), 'style'=>'cursor:pointer'],
		'options'=>['class'=>'modal']
		]);?>
		<div class="form-group">
			<input type="text" id="new-list-code" placeholder="Code" class="form-control" >
			<span class="help-block hidden help-block-code-exist"><?=Yii::t('app', 'Code already exist')?></span>
			<span class="help-block hidden help-block-code-empty"><?=Yii::t('app', 'Fill the code field')?></span>
		</div>
		<div class="form-group">
			<input type="text" id="new-list-value" placeholder="Value" class="form-control" >
			<span class="help-block hidden help-block-value-empty"><?=Yii::t('app', 'Fill the value field')?></span>		
		</div>
		<?Modal::end();?>		
		</li>    
	</ul>
</div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
