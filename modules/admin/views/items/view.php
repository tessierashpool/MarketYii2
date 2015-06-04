<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Items */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Category Select'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $categoryModel->name, 'url' => ['list','category_id'=>$categoryModel->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id, 'category_id'=>$categoryModel->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description',
            'price',
            'quantity',
            [
                'attribute' => 'category_id',
                'value' => $categoryModel->name,           
            ],
            'created_at:date',
            'updated_at:date',
            ['attribute'=>'created_by', 'value'=>User::find()->select('username')->where(['id'=>$model->created_by])->one()->username],
            ['attribute'=>'updated_by', 'value'=>User::find()->select('username')->where(['id'=>$model->updated_by])->one()->username],
        ],
    ]);    
    ?>
    <?
    //Get full info about parameters and variants
    $fullInfo = $model->fullInfo;
    ?>
    <div class="panel panel-default">
        <div class="panel-heading"><strong><i class="glyphicon glyphicon-list-alt"></i> <?=Yii::t('app', 'Variants')?></strong></div>
        <ul class="list-group">
            <?
                foreach($fullInfo['category_variants'] as $cat_variant)
                {
                    $arVarList = [];
                    if(count($fullInfo['variants'][$cat_variant['id']])>0)
                    {
                        $arVarList = ArrayHelper::map($cat_variant['listValues'],'code','value');
                        foreach ($fullInfo['variants'][$cat_variant['id']] as $key => $value) {
                            echo '<li class="list-group-item">'.$cat_variant['name'].' '.$arVarList[$value['code']].': '.intval($value['quantity']).'</li>';
                        }
                    }    
                }
            ?>
        </ul>
    </div>             
    <div class="panel panel-default">
        <div class="panel-heading"><strong><i class="glyphicon glyphicon-picture"></i> <?=Yii::t('app', 'Images')?></strong></div>
        <div class="panel-body">  
                <?
                foreach ($model->getImages()  as $img) 
                {
                    echo '<a target="blank" href="'.$img->getUrl().'">'.Html::img($img->getUrl('150x'),['class'=>'img-thumbnail','style'=>'height:160px;margin-right:10px']).'</a>';
                }
                ?>              
            
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading"><strong><i class="glyphicon glyphicon-list-alt"></i> <?=Yii::t('app', 'Parameters')?></strong></div>
        <ul class="list-group">
            <?
                foreach($fullInfo['category_parameters'] as $cat_parameters)
                {
                    if(isset($fullInfo['parameters'][$cat_parameters['id']]))
                    {
                        if($cat_parameters['type']=='list')
                        {
                            $arVarList = ArrayHelper::map($cat_parameters['listValues'],'code','value');
                            echo '<li class="list-group-item"><strong>'.$cat_parameters['name'].':</strong> '.$arVarList[$fullInfo['parameters'][$cat_parameters['id']]].'</li>';
                        }
                        else
                        {
                            echo '<li class="list-group-item"><strong>'.$cat_parameters['name'].':</strong> '.$fullInfo['parameters'][$cat_parameters['id']].'</li>';                           
                        }
                    }
                }
            ?>
        </ul>
    </div>    
</div>
