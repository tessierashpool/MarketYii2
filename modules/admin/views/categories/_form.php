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
    
    <?= $form->field($model, 'active')->dropDownList(['1'=>Yii::t('app', 'Active') ,'0'=>Yii::t('app', 'Deactive')]) ?>
    
    <?= $form->field($model, 'code')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'have_variants')->checkbox(['onchange'=>'if($(this).prop("checked")){$("#variants-cont").removeClass("hidden")}else{$("#variants-cont").addClass("hidden")};']) ?>    

    <?= $form->field($model, 'order')->hiddenInput(['value' =>$model->find()->orderBy('order DESC')->one()->order+1])->label(false) ?>

    <?= $form->field($model, 'parent_id')->hiddenInput(['value' => $this->params['customParam']['parent']])->label(false) ?>

    <?= $form->field($model, 'depth')->hiddenInput(['value' => $this->params['customParam']['depth']])->label(false) ?>

<script>
    var existVariants = [];
    function selectVariant(name,code,id){
        if(existVariants.indexOf(id)<0)
        {
            var paramLine = '<li class="list-group-item  li-variants selected-variant-'+id+'"><small><span class="label label-success">new</span></small> ';
            paramLine += name;
            paramLine += ' ['+code+'] ';
            paramLine += '<a href="javascript:void(0)" onclick="deleteVariant('+id+')"><i class="glyphicon glyphicon-trash"></i></a>';
            paramLine += ' <a href="javascript:void(0)" onclick="variantOrderUp(this)"><i class="glyphicon glyphicon-arrow-up"></i></a>';                        
            paramLine += ' <a href="javascript:void(0)" onclick="variantOrderDown(this)"><i class="glyphicon glyphicon-arrow-down"></i></a>';  
            paramLine += '<input type="hidden" name="variants[]" value="'+id+'" /></li>';
            $('.add-variants-li').before(paramLine);
            selectedVariant(id);
            $('#variants').modal('hide'); 
        }
        else
        {
            $('.link-variant-'+id).next('span').fadeIn(1).delay( 1800 ).fadeOut(1);
        }    
    }

    function selectedVariant(id){
        existVariants.push(id);
        $('.link-variant-'+id).css({'color':'#999','text-decoration':'none','cursor':'default'});
    }

    function deleteVariant(id){
        $('.selected-variant-'+id).remove();
        $('.link-variant-'+id).css({'color':'','text-decoration':'','cursor':''});
        if(existVariants.indexOf(id)>=0)
            existVariants.splice(existVariants.indexOf(id), 1);
    }

    function variantOrderUp(e)
    {
        var curent_li = $(e).parent('.li-variants');
        var prev_li = curent_li.prev('.li-variants');
        if(prev_li.length)    
        {
            curent_li.after(prev_li);                  
        } 
    }

    function variantOrderDown(e)
    {
        var curent_li = $(e).parent('.li-variants');
        var next_li = curent_li.next('.li-variants');
        if(next_li.length)    
        {
            curent_li.before(next_li);                  
        } 
    }    

    function addParentVariants(e)
    {
        $(e).parent().next('span').children('i').each(function(){
            deleteVariant(parseInt($(this).data('variant-id')));
            selectVariant($(this).data('variant-name'),$(this).data('variant-code'), parseInt($(this).data('variant-id')));

        })
        
    }
</script>
<div class="panel panel-default <?if(!$model->have_variants)echo 'hidden';?>" id="variants-cont">
  <div class="panel-heading"><strong>Variants</strong></div>
  <ul class="list-group">
    <?
        if(count($variantsToCategories)>0)
            foreach($variantsToCategories as $variant)
            {
                echo '<li class="list-group-item li-variants selected-variant-'.$variant['id_variant'].'">'.$variant['variantsInfo']['name'].
                    ' ['.$variant['variantsInfo']['code'].'] <a href="javascript:void(0)" onclick="deleteVariant('.
                    $variant['id_variant'].')"><i class="glyphicon glyphicon-trash"></i></a>'.
                    ' <a href="javascript:void(0)" onclick="variantOrderUp(this)"><i class="glyphicon glyphicon-arrow-up"></i></a>'.                        
                    ' <a href="javascript:void(0)" onclick="variantOrderDown(this)"><i class="glyphicon glyphicon-arrow-down"></i></a>'. 
                    '<input type="hidden" name="variants[]" value="'.$variant['id_variant'].'" />';    
                $this->registerJs('$("document").ready(function(){ selectedVariant('.$variant['id_variant'].'); });');
                echo '</li>';
            }    

    ?>    
    <li class="list-group-item add-variants-li">
        <?Modal::begin([
        'header' => '<h4><i class="glyphicon glyphicon-list-alt"></i> Variants</h4>',
        'id'=>'variants',
        'toggleButton' => ['tag'=>'a', 'label' => '<i class="glyphicon glyphicon-plus"></i> Add variant', 'style'=>'cursor:pointer'],
        'options'=>['class'=>'modal']
        ]);
            //Prepare parent category variants
            if(count($parentVariants)>0)
            {
                echo '<div class="panel panel-default">';
                echo '<ul class="list-group">';                
                echo '<li class="list-group-item"><a href="javascript:void(0)" onclick="addParentVariants(this)"><i class="glyphicon glyphicon-plus"></i> Add all parent variants</a></li>';
                echo '<span style="display:none">';
                foreach ($parentVariants as $key => $value) 
                {
                    echo '<i data-variant-name="'.$value['variantsInfo']['name'].'" data-variant-code="'.$value['variantsInfo']['code'].'" data-variant-id="'.$value['id_variant'].'"></i>';
                }
                echo '</span>';
                echo '</ul>';
                echo '</div>';         
            }
            //Prepare all variants in sistem
            foreach($variantsList as $category)
            {    
                echo '<div class="panel panel-default">';
                echo '<div class="panel-heading">'.$category['name'].'</div>';
                echo '<ul class="list-group">';
                foreach ($category['params'] as $variant) {
                    echo '<li class="list-group-item"><a class="link-variant-'.$variant['id'].'" href="javascript:void(0)" onclick="selectVariant(\''.$variant['name'].'\',\''
                        .$variant['code'].'\','.$variant['id'].')"><i class="glyphicon glyphicon-plus"></i> '
                        .$variant['name'].' ['.$variant['code'].'] </a> <span class="pull-right" style="display:none;color:#d9534f"> selected</span></li>';
                }   
                echo '</ul>';            
                echo '</div>';            
            } 
        Modal::end();?>
    </li>
  </ul>
</div>    
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
