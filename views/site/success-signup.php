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

$this->title = "Success sign up";
?>    
<div class="row checkout-content">
    <div class="col-xs-12">
        <div class="alert alert-success" role="alert">
            Your account has been created successfully and is ready to use
        </div>
    </div>                              
</div>                      