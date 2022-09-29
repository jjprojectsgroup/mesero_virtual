<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Pedido $model */
/** @var yii\widgets\ActiveForm $form */

$readonly=true;
$activado = [ 'Activo' => 'Activo', 'Cerrado' => 'Cerrado'];

?>

<div class="pedido-form">

<?php $form = ActiveForm::begin([
   'fieldConfig' => [
      'errorOptions' => [
           'encode' => false,
           'class' => 'help-block',
           'style'=>'color:red;',
       ],
   ],
]);?>
    <?= $form->field($model, 'restaurante_id')->textInput(['readonly'=> $readonly]) ?>

    <?= $form->field($model, 'cliente_id')->textInput(['readonly'=> $readonly]) ?>

    <?= $form->field($model, 'valor')->textInput(['readonly'=> $readonly]) ?>

    <?= $form->field($model, 'estado')->dropDownList($activado, ['readonly'=> $readonly]) ?>

    <div class="form-group">
        <p></p>
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
