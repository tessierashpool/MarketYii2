<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\web\UploadedFile;

/* @var $this yii\web\View */
/* @var $model app\models\Items */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="items-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data'] ]); ?>
    
    <?= $form->field($model, 'active')->dropDownList(['1'=>Yii::t('app', 'Active') ,'0'=>Yii::t('app', 'Deactive')]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'category_id')->hiddenInput(['value' => $categoryModel->id])->label(false) ?>

    <?= $form->field($model, 'status')->dropDownList($model->statusList) ?>

    <?if($categoryModel->have_variants):?>
        <!-- Variants  fields start-->
        <script>
            var existVariants = [];
            function selectVariant(name,code,parent_name,parent_id){
                if(existVariants.indexOf(code)<0)
                {
                    var paramLine = '<li class="list-group-item li-variants selected-variant-'+code+'">';
                    paramLine += '<div class="input-group">';
                    paramLine += '<span class="input-group-addon" id="basic-addon1">'+parent_name+'</span>';
                    paramLine += '<span class="input-group-addon" id="basic-addon2">'+name+'</span>';
                    paramLine += '<input type="text" class="form-control" name="Items[variants]['+parent_id+']['+code+'][quantity]" placeholder="Quantity" aria-describedby="basic-addon1">';
                    paramLine += '<input type="hidden" name="Items[variants]['+parent_id+']['+code+'][value]" value="'+code+'" />';
                    paramLine += '<input type="hidden" name="Items[variants]['+parent_id+']['+code+'][parameter_id]" value="'+parent_id+'" />';
                    paramLine += '<span class="input-group-btn">';
                    paramLine += '<button onclick="deleteVariant(\''+code+'\')" class="btn btn-default" type="button"><i class="glyphicon glyphicon-trash"></i></button>';
                    paramLine += '</span>';             
                    paramLine += '</div>';                
                    paramLine += '</li>';           
                    $('.add-variants-li').before(paramLine);
                    selectedVariant(code);
                    $('#variants').modal('hide'); 
                }
                else
                {
                    $('.link-variant-'+id).next('span').fadeIn(1).delay( 1800 ).fadeOut(1);
                }    
            }

            function selectedVariant(code){
                existVariants.push(code);
                $('.link-variant-'+code).css({'color':'#999','text-decoration':'none','cursor':'default'});
            }

            function deleteVariant(code){
                $('.selected-variant-'+code).remove();
                $('.link-variant-'+code).css({'color':'','text-decoration':'','cursor':''});
                if(existVariants.indexOf(code)>=0)
                    existVariants.splice(existVariants.indexOf(code), 1);
            }

        </script>

            <div class="panel panel-default">
                <div class="panel-heading"><strong><i class="glyphicon glyphicon-list-alt"></i> <?=Yii::t('app', 'Variants')?></strong></div>
                <ul class="list-group">
                    <?
                    //Variants list
                    $variants = $categoryModel->fullVariants;
                    foreach($variants as $cat_variant)
                    {  
                        $arVariantName = [];
                        if(count($model->variants[$cat_variant['id']])>0)
                        {
                            $arVariantName = ArrayHelper::map($cat_variant['listValues'],'code','value');
                            foreach($model->variants[$cat_variant['id']] as $variant)
                            {
                                echo '<li class="list-group-item li-variants selected-variant-'.$variant['value'].'">';
                                echo '<div class="input-group">';
                                echo '<span class="input-group-addon" id="basic-addon1">'.$cat_variant['name'].'</span>';
                                echo '<span class="input-group-addon" id="basic-addon2">'.$arVariantName[$variant['value']].'</span>';
                                echo '<input type="text" class="form-control" value="'.$variant['quantity'].'" name="Items[variants]['.$variant['parameter_id'].']['.$variant['value'].'][quantity]" placeholder="Quantity" aria-describedby="basic-addon1">';
                                echo '<input type="hidden" name="Items[variants]['.$variant['parameter_id'].']['.$variant['value'].'][value]" value="'.$variant['value'].'" />';
                                echo '<input type="hidden" name="Items[variants]['.$variant['parameter_id'].']['.$variant['value'].'][parameter_id]" value="'.$variant['parameter_id'].'" />';
                                echo '<span class="input-group-btn">';
                                echo '<button onclick="deleteVariant(\''.$variant['value'].'\')" class="btn btn-default" type="button"><i class="glyphicon glyphicon-trash"></i></button>';
                                echo '</span>';         
                                echo '</div>';  
                                $this->registerJs('$("document").ready(function(){ selectedVariant(\''.$variant['value'].'\'); });');                                    
                                echo '</li>';                 
                            }
                        }    
                    }


                    ?>
                    <li class="list-group-item add-variants-li">
                        <?Modal::begin([
                        'header' => '<h4><i class="glyphicon glyphicon-list-alt"></i> '.Yii::t('app', 'Variants').'</h4>',
                        'id'=>'variants',
                        'toggleButton' => ['tag'=>'a', 'label' => '<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add variants'), 'style'=>'cursor:pointer'],
                        'options'=>['class'=>'modal']
                        ]);
                            foreach($variants as $variant)
                            {    
                                echo '<div class="panel panel-default">';
                                echo '<div class="panel-heading">'.$variant['name'].'</div>';
                                echo '<ul class="list-group">';
                                foreach ($variant['listValues'] as $listValue) {
                                    echo '<li class="list-group-item"><a class="link-variant-'.$listValue['code'].'" href="javascript:void(0)" onclick="selectVariant(\''.$listValue['value'].'\',\''.$listValue['code'].'\',\''.$variant['name'].'\',\''.$variant['id'].'\')">'.$listValue['value'].'</a></li>';
                                }   
                                echo '</ul>';            
                                echo '</div>';            
                            }                     
                        Modal::end();?>
                    </li>            
                </ul>
            </div>  
        <!-- Variants  fields end-->    
    <?else:?> 
        <?= $form->field($model, 'quantity')->textInput() ?>
    <?endif;?> 
    <div class="panel panel-default">
        <div class="panel-heading"><strong><i class="glyphicon glyphicon-picture"></i> <?=Yii::t('app', 'Images')?></strong></div>
        <div class="panel-body">    
            <?

                //$image = $model->getImage();
                echo FileInput::widget([
                    'model' => $model,
                    'attribute' => 'images[]',
                    'options' => [
                    'multiple' => true, 
                    'id'=>'images-kartik',
                    'accept' => 'image/*'
                    ],
                    'pluginOptions' => [
                        'maxFileCount' =>6,
                        'showUpload' => false,
                        'initialPreview'=>$model->getInitialPreview(),
                        'overwriteInitial'=>true ,
                        'showCaption' => false,                                               
                    ],
                    'pluginEvents'=>[
                        "fileclear" => "function() { $('#clearImages').val('1'); }"
                    ]
                ]);
            ?>
            <?= $form->field($model, 'clearImages')->hiddenInput(['id' => 'clearImages','value'=>'0'])->label(false) ?>
        </div>
    </div>
<!-- Parameters  fields start-->         
    <div class="panel panel-default">
        <div class="panel-heading"><strong><i class="glyphicon glyphicon-list-alt"></i> Parameters</strong></div>
        <ul class="list-group">
            <?
            //Parameters list
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
                    echo  '<label for="">'.$parameter['name'].'</label>';
                    echo '<input  value="'.$model->parameters[$parameter['id']].'" name="Items[parameters]['.$parameter['id'].']"  type="text" class="form-control" >';
                    
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
<!-- Parameters  fields end--> 
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>        

    <?php ActiveForm::end(); ?>

</div>
