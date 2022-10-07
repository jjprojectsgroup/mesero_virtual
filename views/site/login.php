<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-lg-offset-3 col-md-offset-3 col-sm-offset-3">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-4 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]); ?>

    <?= $form->field($model, 'email')->input('email')->label('Correo Electronico') ?>

    <?= $form->field($model, 'password')->passwordInput()->label('Contraseña') ?>

    <?= $form->field($model, 'rememberMe')->checkbox([
        'template' => "<div class=\"offset-lg-1 col-lg-3 custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ])->label('Recuerdame') ?>

    <div class="form-group">
        <div class="offset-lg-1 col-lg-11">
            <p></p>
            <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary col-lg-3 col-md-3 col-sm-3 col-xs-6 col-lg-offset-3 col-md-offset-3 col-sm-offset-3', 'name' => 'login-button', 'style' => 'float:left;']) ?>
            <?= Html::a("Registro", ['/user/create'], ['class' => 'btn btn-success col-lg-3 col-md-3 col-sm-3 col-xs-6 col-lg-offset-3 col-md-offset-3 col-sm-offset-3', 'style' => 'float:right;']) ?>
            <p></p>&nbsp; &nbsp; &nbsp; </br></br>
        <?php //Html::a("Recuperar Contraseña", ['/site/recoverpass'], ['class' => 'btn btn-success  ', 'style' => 'aling:center;']) ?>


        </div>

    </div>
    <?php ActiveForm::end(); ?>

</div>