<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Cliente $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="cliente-form">

<?php $form = ActiveForm::begin([
   'fieldConfig' => [
      'errorOptions' => [
           'encode' => false,
           'class' => 'help-block',
           'style'=>'color:red;',
       ],
   ],
]);?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <!--<?= $form->field($model, 'saldo')->textInput() ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'hora')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'usuario_id')->textInput() ?>-->

    <div class="form-group">
        <p></p>
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
