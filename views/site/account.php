<?php
use app\models\Items;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
$this->registerJs("
$(function () {
  $('[data-toggle=\'tooltip\']').tooltip()
})
    ",\yii\web\View::POS_BEGIN);

$this->title = "Account";
$this->params['breadcrumbs'][] = $this->title;
?>    
<div class="row checkout-content">
    <div class="col-xs-12">
        <h2 class="custom-h2"><?=$this->title?></h2>
        <?php $form = ActiveForm::begin(); ?>
            <div class="user-details">
                <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'adress')->textInput(['maxlength' => true]) ?>               
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'i-add-cart-link cart-checkout-btn pull-left']) ?>
                </div>
            </div>
        <?php ActiveForm::end(); ?> 
    </div>                              
</div>                      