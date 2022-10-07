<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
 
<h3><?= $msg ?></h3>
 
<h1>Reset Password</h1>
<?php $form = ActiveForm::begin([
    'method' => 'post',
    'enableClientValidation' => true,
]);
?>

<div class="form-group">
 <?= $form->field($model, "email")->input("email")->label('Correo') ?>  
</div>
 
<div class="form-group">
 <?= $form->field($model, "password")->input("password")->label('Contraseña') ?>  
</div>
 
<div class="form-group">
 <?= $form->field($model, "password_repeat")->input("password")->label('Repetir contraseña') ?>  
</div>

<div class="form-group">
 <?= $form->field($model, "verification_code")->input("text")->label('Codigo de verificacion') ?>  
</div>

<div class="form-group">
 <?= $form->field($model, "recover")->input("hidden")->label(false) ?>  
</div>
 
<?= Html::submitButton("Cambiar Contraseña", ["class" => "btn btn-primary"]) ?>
 
<?php $form->end() ?>
