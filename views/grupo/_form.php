<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Grupo $model */
/** @var yii\widgets\ActiveForm $form */
$tipo=Yii::$app->user->identity->tipo;
?>

<div class="grupo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    <?php if($tipo!=null && $tipo=='0'  ){?>
    <?= $form->field($model, 'restaurante_id')->textInput(['readonly'=> true])  ?>
    <?php } ?>
<br>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Menú', ['grupo/index'], ["class" => "btn btn-primary menuA", 'role' => "button"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
