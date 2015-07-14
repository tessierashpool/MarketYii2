<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;
use app\models\Items;
use app\models\Status;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'Order №'.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->dropDownList(Status::getList()) ?>

    <div class="form-group">
        <?= Html::submitButton('Update status', ['class' =>'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            ['attribute'=>'status','format'=>'raw','value'=>'<span class="label label-primary">'.Status::getList()[$model->status].'</span>'],
            ['attribute'=>'user_id','format'=>'raw','value'=>$model->user_id>0?Html::a($model->user_id,['/admin/user/view','id'=>$model->user_id]):$model->user_id],
            'first_name',
            'last_name',
            'state',
            'city',
            'adress',
            'telephone',
            'email:email',
            'delivery_id',
            'delivery_price',
            'payment_id',
            'total_price',
            'created_at:date',
            'updated_at:date',
            ['attribute'=>'created_by', 'value'=>User::find()->select('username')->where(['id'=>$model->created_by])->one()->username],
            ['attribute'=>'updated_by', 'value'=>User::find()->select('username')->where(['id'=>$model->updated_by])->one()->username],
        ],
    ]) ?>
        <h3>Items</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>   
            <?foreach ($model->items as $item):?>      
                <tr>
                    <td><?=Html::img(Items::findOne($item->id)->getImage()->getUrl('260x'),['style'=>'max-width:100px'])?></td>
                    <?if($item->id>0):?>
                        <td><?=Html::a($item->item_name.', '.$item->item_size,['/admin/items/view','id'=>$item->id])?> </td>
                    <?else:?>
                        <td><?=$item->item_name?>, <?=$item->item_size?> </td>
                    <?endif;?>
                    
                    <td><?=$item->item_quantity?></td>
                    <td><?=$item->item_price?></td>
                </tr>
            <?endforeach;?>           
        </table>
</div>
