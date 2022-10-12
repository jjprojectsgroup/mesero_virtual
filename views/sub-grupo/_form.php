<?php

use app\models\Grupo;
use app\models\Restaurante;
use app\models\SubGrupo;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SubGrupo $model */
/** @var yii\widgets\ActiveForm $form */

$grupos = Grupo::find()->all();
$subGrupos = SubGrupo::find()->all();
$nombreGrupos = null;
$nombreSubGrupos = null;

$restaurante = Restaurante::findOne(['usuario_id' => Yii::$app->user->identity->id]);

if (Yii::$app->user->identity->tipo == 1) {
    foreach ($grupos as $key => $grupo) {
        if ($grupo->restaurante_id == $restaurante->id || $grupo->restaurante_id == null) {
            $nombreGrupos[$grupo->id] = $grupo->nombre;
        }
    }
} else {
    foreach ($grupos as $key => $grupo) {
        $nombreGrupos[$grupo->id] = $grupo->nombre;
    }
}
?>

<div class="sub-grupo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'grupo_id')->dropDownList($nombreGrupos, ['prompt' => 'Seleccione un Grupo', 'id' => 'option', 'onchange' => 'almacenar()']) ?>

    <?= $form->field($model, 'restaurante_id')->textInput(['value' => $restaurante->id, 'style' => 'display:none;'])->label(false) ?>
    <p></p>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Menú', ['sub-grupo/index'], ["class" => "btn btn-primary menuA", 'role' => "button"]) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>