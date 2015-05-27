<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Categories */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'code',
            'name',
            'description',
            'have_variants:boolean',
            'parent_id',
            'depth',
            'created_at:date',
            'updated_at:date',
            ['attribute'=>'created_by', 'value'=>User::find()->select('username')->where(['id'=>$model->created_by])->one()->username],
            ['attribute'=>'updated_by', 'value'=>User::find()->select('username')->where(['id'=>$model->updated_by])->one()->username]
        ],
    ]) ?>
    <?if(count($variantsToCategories)>0):?>
        <div class="panel panel-default">
          <div class="panel-heading"><strong>Variants</strong></div>
          <ul class="list-group">
            <?
                foreach($variantsToCategories as $variant)
                {
                    echo '<li class="list-group-item">'.$variant['variantsInfo']['name'].
                        ' ['.$variant['variantsInfo']['code'].'] ';    
                    echo '</li>';
                }    
            ?>
          </ul>
        </div>
    <?endif;?>

    <div class="panel panel-default">
      <div class="panel-heading"><strong>Parameters</strong></div>
      <ul class="list-group">
        <?
            if(count($parametersToCategories)>0)
                foreach($parametersToCategories as $parameter)
                {
                    echo '<li class="list-group-item">'.$parameter['parametersInfo']['name'].
                        ' ['.$parameter['parametersInfo']['code'].'] ';    
                    echo '</li>';
                }    
        ?>
      </ul>
    </div>
</div>
