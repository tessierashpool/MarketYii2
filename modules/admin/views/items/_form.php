<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\base\DynamicModel;

/* @var $this yii\web\View */
/* @var $model app\models\Items */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="items-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'category_id')->hiddenInput(['value' => $categoryModel->id])->label(false) ?>

    <div class="panel panel-default">
        <div class="panel-heading"><strong><i class="glyphicon glyphicon-list-alt"></i> Parameters</strong></div>
        <ul class="list-group">
            <?
            //echo $model->parameters;
            $arParameters = $categoryModel->fullParameters;
           // if(count($arParameters)>0)
            foreach($arParameters as $parameter)
            {
                echo '<li class="list-group-item">';
                if($model->hasErrors('parameters'.$parameter['id']))
                    echo '<div class="form-group has-error" style="margin-bottom:0">';
                else
                    echo '<div class="form-group" style="margin-bottom:0">';
                if($parameter['type']=='text')
                {
                    //echo $form->field($model, 'parameters['.$parameter['id'].']')->input('text',['placeholder'=>$parameter['name']])->error(false);
                    echo '<input  value="'.$model->parameters[$parameter['id']].'" name="Items[parameters]['.$parameter['id'].']" placeholder="'.$parameter['name'].'" type="text" class="form-control" >';
                    
                }
                elseif($parameter['type']=='list')
                {
                    
                    echo '<label >'.$parameter['name'].'</label>';
                    echo Html::dropDownList('Items[parameters]['.$parameter['id'].']',$model->parameters[$parameter['id']], ArrayHelper::map($parameter['listValues'],'code','value'),['class'=>'form-control']);
                    
                }                
                echo Html::error($model,'parameters'.$parameter['id'],['class'=>'help-block','style'=>"margin:0"]);
                echo '</div>';
                echo '</li>';
            }
            ?>
            
        </ul>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>        

    <?php ActiveForm::end(); ?>
<script>
jQuery(document).ready(function () {
     // TODO: add 'use strict'; if YII_ENV_DEBUG


jQuery('#w0').yiiActiveForm([{"id":"items-name","name":"name","container":".field-items-name","input":"#items-name","validate":function (attribute, value, messages, deferred, $form) {yii.validation.string(value, messages, {"message":"Значение «Name» должно быть строкой.","max":255,"tooLong":"Значение «Name» должно содержать максимум 255 символов.","skipOnEmpty":1});}},{"id":"items-description","name":"description","container":".field-items-description","input":"#items-description","validate":function (attribute, value, messages, deferred, $form) {yii.validation.string(value, messages, {"message":"Значение «Description» должно быть строкой.","max":255,"tooLong":"Значение «Description» должно содержать максимум 255 символов.","skipOnEmpty":1});}},{"id":"items-price","name":"price","container":".field-items-price","input":"#items-price","validate":function (attribute, value, messages, deferred, $form) {yii.validation.number(value, messages, {"pattern":/^\s*[+-]?\d+\s*$/,"message":"Значение «Price» должно быть целым числом.","skipOnEmpty":1});}},{"id":"items-category_id","name":"category_id","container":".field-items-category_id","input":"#items-category_id","validate":function (attribute, value, messages, deferred, $form) {yii.validation.number(value, messages, {"pattern":/^\s*[+-]?\d+\s*$/,"message":"Значение «Category» должно быть целым числом.","skipOnEmpty":1});}}], []);
});    

</script>
</div>
