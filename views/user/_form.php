<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */

$tipo = [ 0 => 'Administrador', 1 => 'Restaurante',  2 => 'Cliente'];
$user = new User();
$user->generateKey();
?>

<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-lg-offset-3 col-md-offset-3 col-sm-offset-3">
<h1><?= Html::encode($model->email) ?></h1>

<?php $form = ActiveForm::begin([
   'fieldConfig' => [
      'errorOptions' => [
           'encode' => false,
           'class' => 'help-block',
           'style'=>'color:red;',
       ],
   ],
]);?>

    <?= $form->field($model, 'email')->input('email')->label('Correo Electronico') ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('Contraseña') ?>

    <?= $form->field($model, 'auth_key')->hiddenInput(['maxlength' => true, 'value' => $user->auth_key] )->label(false) ?> 

    <?= $form->field($model, 'access_token')->hiddenInput(['maxlength' => true, 'value' => $user->access_token])->label(false) ?>

    <?= $form->field($model, 'tipo')->dropDownList($tipo, ['prompt' => 'Seleccione Un Tipo De Usuario' ])->label('Tipo de Usuario') ?>

    <div class="form-group">
    <p></p>
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
