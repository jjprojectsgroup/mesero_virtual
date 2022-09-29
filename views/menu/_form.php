<?php

use app\models\Grupo;
use app\models\Menu;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Menu $model */
/** @var yii\widgets\ActiveForm $form */
//$grupo = [ 'Bebidas' => 'Bebidas', 'Entradas' => 'Entradas',  'Platos fuertes' => 'Platos fuertes', 'Postres' => 'Postres'];
$grupos = Grupo::find()->all();
$nombreGrupos =null;
foreach ($grupos as $grupo) {
  $nombreGrupos[] = $grupo->nombre;
}
?>
<div class="menu-form">
<?php $form = ActiveForm::begin([
   'fieldConfig' => [
      'errorOptions' => [
           'encode' => false,
           'class' => 'help-block',
           'style'=>'color:red;',
       ],
   ],
]);?>

    <?= $form->field($model, 'grupo')->dropDownList($nombreGrupos, ['prompt' => 'Seleccione un Grupo' ])?>

  <!--  <?= $form->field($model, 'restaurante_id')->textInput() ?>-->

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'precio')->textInput() ?>

  <!--  <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'hora')->textInput(['maxlength' => true]) ?> -->

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
