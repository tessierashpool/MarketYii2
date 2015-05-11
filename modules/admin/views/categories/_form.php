<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Categories */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="categories-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'order')->hiddenInput(['value' =>$model->find()->orderBy('order DESC')->one()->order+1])->label(false) ?>

    <?= $form->field($model, 'parent_id')->hiddenInput(['value' => $this->params['customParam']['parent']])->label(false) ?>

    <?= $form->field($model, 'depth')->hiddenInput(['value' => $this->params['customParam']['depth']])->label(false) ?>
<script>
    var existParams = [];
    function selectParameter(name,code,id){
        if(existParams.indexOf(id)<0)
        {
            var paramLine = '<li class="list-group-item  li-params selected-paremeter-'+id+'"><small><span class="label label-success">new</span></small> ';
            paramLine += name;
            paramLine += ' ['+code+'] ';
            paramLine += '<a href="javascript:void(0)" onclick="deleteParameter('+id+')"><i class="glyphicon glyphicon-trash"></i></a>';
            paramLine += ' <a href="javascript:void(0)" onclick="parameterOrderUp(this)"><i class="glyphicon glyphicon-arrow-up"></i></a>';                        
            paramLine += ' <a href="javascript:void(0)" onclick="parameterOrderDown(this)"><i class="glyphicon glyphicon-arrow-down"></i></a>';  
            paramLine += '<input type="hidden" name="params[]" value="'+id+'" /></li>';
            $('.add-param-li').before(paramLine);
            selectedLink(id);
            $('#params').modal('hide'); 
        }
        else
        {
            $('.link-param-'+id).next('span').fadeIn(1).delay( 1800 ).fadeOut(1);
        }    
    }

    function selectedLink(id){
        existParams.push(id);
        $('.link-param-'+id).css({'color':'#999','text-decoration':'none','cursor':'default'});
    }

    function deleteParameter(id){
        $('.selected-paremeter-'+id).remove();
        $('.link-param-'+id).css({'color':'','text-decoration':'','cursor':''});
        if(existParams.indexOf(id)>=0)
            existParams.splice(existParams.indexOf(id), 1);
    }

    function parameterOrderUp(e)
    {
        var curent_li = $(e).parent('.li-params');
        var prev_li = curent_li.prev('.li-params');
        if(prev_li.length)    
        {
            curent_li.after(prev_li);                  
        } 
    }

    function parameterOrderDown(e)
    {
        var curent_li = $(e).parent('.li-params');
        var next_li = curent_li.next('.li-params');
        if(next_li.length)    
        {
            curent_li.before(next_li);                  
        } 
    }    

    function addParentParams(e)
    {
        $(e).parent().next('span').children('i').each(function(){
            deleteParameter(parseInt($(this).data('param-id')));
            selectParameter($(this).data('param-name'),$(this).data('param-code'), parseInt($(this).data('param-id')));

        })
        
    }
</script>
<div class="panel panel-default">
  <div class="panel-heading"><strong>Parameters</strong></div>
  <ul class="list-group">
    <?
        if(count($parametersToCategories)>0)
            foreach($parametersToCategories as $parameter)
            {
                echo '<li class="list-group-item li-params selected-paremeter-'.$parameter['id_parameter'].'">'.$parameter['parametersInfo']['name'].
                    ' ['.$parameter['parametersInfo']['code'].'] <a href="javascript:void(0)" onclick="deleteParameter('.
                    $parameter['id_parameter'].')"><i class="glyphicon glyphicon-trash"></i></a>'.
                    ' <a href="javascript:void(0)" onclick="parameterOrderUp(this)"><i class="glyphicon glyphicon-arrow-up"></i></a>'.                        
                    ' <a href="javascript:void(0)" onclick="parameterOrderDown(this)"><i class="glyphicon glyphicon-arrow-down"></i></a>'. 
                    '<input type="hidden" name="params[]" value="'.$parameter['id_parameter'].'" />';    
                $this->registerJs('$("document").ready(function(){ selectedLink('.$parameter['id_parameter'].'); });');
                echo '</li>';
            }    

    ?>
    <li class="list-group-item add-param-li">
        <?Modal::begin([
        'header' => '<h4><i class="glyphicon glyphicon-list-alt"></i> Parameters</h4>',
        'id'=>'params',
        'toggleButton' => ['tag'=>'a', 'label' => '<i class="glyphicon glyphicon-plus"></i> Add parameter', 'style'=>'cursor:pointer'],
        'options'=>['class'=>'modal']
        ]);
            //Prepare parent category parameters
            if(count($parentParameters)>0)
            {
                echo '<div class="panel panel-default">';
                echo '<ul class="list-group">';                
                echo '<li class="list-group-item"><a href="javascript:void(0)" onclick="addParentParams(this)"><i class="glyphicon glyphicon-plus"></i> Add all parent parameters</a></li>';
                echo '<span style="display:none">';
                foreach ($parentParameters as $key => $value) 
                {
                    echo '<i data-param-name="'.$value['parametersInfo']['name'].'" data-param-code="'.$value['parametersInfo']['code'].'" data-param-id="'.$value['id_parameter'].'"></i>';
                }
                echo '</span>';
                echo '</ul>';
                echo '</div>';         
            }
            //Prepare all parameters in sistem
            foreach($parametersList as $category)
            {    
                echo '<div class="panel panel-default">';
                echo '<div class="panel-heading">'.$category['name'].'</div>';
                echo '<ul class="list-group">';
                foreach ($category['params'] as $params) {
                    echo '<li class="list-group-item"><a class="link-param-'.$params['id'].'" href="javascript:void(0)" onclick="selectParameter(\''.$params['name'].'\',\''
                        .$params['code'].'\','.$params['id'].')"><i class="glyphicon glyphicon-plus"></i> '
                        .$params['name'].' ['.$params['code'].'] </a> <span class="pull-right" style="display:none;color:#d9534f"> selected</span></li>';
                }   
                echo '</ul>';            
                echo '</div>';            
            } 
        Modal::end();?>
    </li>
  </ul>
</div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
