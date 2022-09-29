<?php

use app\models\Restaurante;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Restaurante $model */
/** @var yii\widgets\ActiveForm $form */
$boton = 'Guardar';
$readonly=false;

if(!Yii::$app->user->isGuest){
$boton = 'Actualizar';
$readonly=true;
$tipo=Yii::$app->user->identity->tipo;
}
$activado = [ 0 => 'Desactivado', 1 => 'Activado'];

?>

<div class="restaurante-form">

<?php $form = ActiveForm::begin([
   'fieldConfig' => [
      'errorOptions' => [
           'encode' => false,
           'class' => 'help-block',
           'style'=>'color:red;',
       ],
   ],
   
]);?>

    <?= $form->field($model, 'nit')->textInput() ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefono')->textInput() ?>

    <?= $form->field($model, 'celular')->textInput() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'readonly'=> $readonly]) ?>

    <?= $form->field($model, 'encargado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ciudad')->textInput(['maxlength' => true]) ?>

    <?php if(Yii::$app->user->isGuest || $tipo!=null && $tipo=='0'  ){?>

    <?= $form->field($model, 'total_mesas')->textInput() ?>

    <?= $form->field($model, 'mensualidad')->textInput() ?>

    <?= $form->field($model, 'codigo_de_activacion')->textInput() ?>

    <?= $form->field($model, 'activado')->dropDownList($activado, ['readonly'=> $readonly]) ?>

    <?= $form->field($model, 'usuario_id')->textInput(['readonly'=> $readonly]) ?>

    <?= $form->field($model, 'fecha')->textInput(['readonly'=> $readonly]) ?>

    <?= $form->field($model, 'hora')->textInput(['maxlength' => true, 'readonly'=> $readonly]) ?>

    <?php }?>

    <div class="form-group">
        <p></p>
        <?= Html::submitButton($boton, ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
