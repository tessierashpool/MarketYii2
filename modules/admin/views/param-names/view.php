<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\ParamNames */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parameters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="param-names-view">

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
            ['attribute'=>'category_id', 'value'=>$model->categoriesList[$model->category_id]],
            'created_at:date',
            'updated_at:date',
            ['attribute'=>'created_by', 'value'=>User::find()->select('username')->where(['id'=>$model->created_by])->one()->username],
            ['attribute'=>'updated_by', 'value'=>User::find()->select('username')->where(['id'=>$model->updated_by])->one()->username],
            'type'
        ],
    ]) ?>
    <?
    if($model->type=='list')
    {
        echo '<div class="panel panel-default values-list" >';
            echo '<div class="panel-heading"><strong>List values</strong></div>';
            echo '<ul class="list-group ">';
            if(count($model->valuesList)>0)
            {
                foreach($model->valuesList as $valueModel)
                {
                    echo '<li class="list-group-item list-value-li">'.$valueModel->value.' ['.$valueModel->code.']';
                    echo '</li>';
                }
            }
            echo '</ul>';
        echo '</div>';            
    }
    ?>

</div>
