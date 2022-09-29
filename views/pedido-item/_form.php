<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PedidoItem $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pedido-item-form">

    <?php $form = ActiveForm::begin(); ?>

  <!--  <?= $form->field($model, 'pedido_id')->textInput() ?>-->

    <?= $form->field($model, 'menu_id')->textInput() ?>

    <?= $form->field($model, 'cantidad')->textInput() ?>

    <?= $form->field($model, 'valor')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
