<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;


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
    ]) ?>
    <div class="panel panel-default">
        <div class="panel-heading"><strong><i class="glyphicon glyphicon-list-alt"></i> <?=Yii::t('app', 'Images')?></strong></div>
        <div class="panel-body">  
                <?
                foreach ($model->getImages()  as $img) 
                {
                    echo Html::img($img->getUrl('150x'),['class'=>'img-thumbnail','style'=>'height:160px;margin-right:10px']);
                }
                ?>              
            
        </div>
    </div>
</div>
