<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row login-content">
    <div class="col-sm-12">
        <h2> <?= Html::encode($this->title) ?></h2>
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "<div class=\"col-sm-4\">{input}</div>\n<div class=\"col-sm-8\">{error}</div>",
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput(['placeholder'=>'Username']) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Password']) ?>

            <?= $form->field($model, 'rememberMe' )->checkbox([
                'template' => '<div class="col-sm-4"><div class="checkbox"><label>{input} Remember me</label></div></div><div class="col-sm-8">{error}</div>',
            ]) ?>

            <div class="form-group">
                <div class="col-sm-12">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>                              
</div>