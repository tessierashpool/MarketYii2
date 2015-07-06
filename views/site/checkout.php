<?php
use app\models\Items;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
$this->registerJs("
$(function () {
  $('[data-toggle=\'tooltip\']').tooltip()
})
    ",\yii\web\View::POS_BEGIN);

$this->title = "Checkout";
$this->params['breadcrumbs'][] = $this->title;
?>    
<div class="row checkout-content">
    <div class="col-xs-12">
        <h2 class="custom-h2"><?=$this->title?></h2>
        <?php $form = ActiveForm::begin(); ?>
            <div class="user-details">
                <h4>Please enter your details</h4>
                <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'adress')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>
                <div class="form-group">
                    <a class="i-add-cart-link cart-checkout-btn pull-left" href="<?=Url::to(['cart'])?>"><i class="glyphicon glyphicon-chevron-left"></i> Back to cart</a> 
                    <?= Html::submitButton(Yii::t('app', 'Submit order'), ['class' => 'i-add-cart-link cart-checkout-btn pull-left', 'style'=>'margin-left:10px']) ?>
                 </div>
            </div>
        <?php ActiveForm::end(); ?> 
    </div>                              
</div>                      