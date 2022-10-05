<?php

use app\models\Grupo;
use app\models\Restaurante;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SubGrupo $model */
/** @var yii\widgets\ActiveForm $form */

$grupos = Grupo::find()->all();
$nombreGrupos = null;
$restaurante = Restaurante::findOne(['usuario_id' => Yii::$app->user->identity->id]);

foreach ($grupos as $key=>$grupo) {
  $nombreGrupos[$grupo->id] = $grupo->nombre;
}
?>

<div class="sub-grupo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'grupo_id')->dropDownList($nombreGrupos, ['prompt' => 'Seleccione un Grupo', 'id'=>'option', 'onchange'=>'almacenar()']) ?>

    <?= $form->field($model, 'restaurante_id')->textInput(['value'=>$restaurante->id, 'style'=>'display:none;'])->label(false) ?>
<p></p>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
