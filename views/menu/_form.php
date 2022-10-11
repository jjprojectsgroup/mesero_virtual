<?php

use app\models\Grupo;
use app\models\Menu;
use app\models\Restaurante;
use app\models\SubGrupo;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Menu $model */
/** @var yii\widgets\ActiveForm $form */
//$grupo = [ 'Bebidas' => 'Bebidas', 'Entradas' => 'Entradas',  'Platos fuertes' => 'Platos fuertes', 'Postres' => 'Postres'];
$existencia = ['En existencia' => 'En existencia', 'Agotado' => 'Agotado'];
$activo = ['Activo' => 'Activo', 'Inactivo' => 'Inactivo'];
$subGrupos = SubGrupo::find()->all();
$grupos = Grupo::find()->all();
$nombreGrupos = null;
$nombreSubGrupos =  null;

$usuario = Restaurante::findOne(['usuario_id' => Yii::$app->user->identity->id]);

$subGrupos = SubGrupo::find()->where(['restaurante_id' => $usuario->id])->all();

if (Yii::$app->user->identity->tipo == 1) {
  foreach ($grupos as $key => $grupo) {
    if ($grupo->restaurante_id == $usuario->id || $grupo->restaurante_id == null) {
      $nombreGrupos[$grupo->id] = $grupo->nombre;
    }
  }
  if ($subGrupos != null) {
    foreach ($subGrupos as $key => $subGrupo) {
      if ($subGrupo->restaurante_id == $usuario->id) {
        $nombreSubGrupos[$subGrupo->id] = $subGrupo->nombre;
      }
    }
  }
} else {
  foreach ($grupos as $key => $grupo) {
    $nombreGrupos[$grupo->id] = $grupo->nombre;
  }
  if ($subGrupos != null) {
    foreach ($subGrupos as $key => $subGrupo) {
      $nombreSubGrupos[$subGrupo->id] = $subGrupo->nombre;
    }
  }
}

/*foreach ($subGrupos as $key => $subGrupo) {
  $nombreSubGrupos[$subGrupo->id] = $subGrupo->nombre;
}*/
?>
<div class="menu-form">
  <?php $form = ActiveForm::begin([
    'fieldConfig' => [
      'errorOptions' => [
        'encode' => false,
        'class' => 'help-block',
        'style' => 'color:red;',
      ],
    ],
  ]); ?>

  <?= $form->field($model, 'grupo')->dropDownList($nombreGrupos, ['prompt' => 'Seleccione un Grupo', 'id' => 'option', 'onchange' => 'almacenar();cambiarSubgrupos()']) ?>
  <?php if (isset($nombreSubGrupos)) { ?>
    <?= $form->field($model, 'sub_grupo')->dropDownList($nombreSubGrupos, ['prompt' => 'Seleccione un Sub-Grupo', 'id' => 'subOption', 'onchange' => 'almacenar()']) ?>

  <?php } ?>


  <!-- <?= $form->field($model, 'restaurante_id')->textInput() ?>-->

  <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

  <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

  <?= $form->field($model, 'precio')->textInput(['type' => 'number', 'min' => 0, 'onkeypress' => 'return validarClic(event)']) ?>

  <!--  <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'hora')->textInput(['maxlength' => true]) ?> -->

  <?= $form->field($model, 'stock')->dropDownList($existencia) ?>

  <?= $form->field($model, 'estado')->dropDownList($activo) ?>

  <div class="form-group">
    <p></p>
    <?= Html::a('Menú', ['menu/index'], ["class" => "btn btn-primary menuA", 'role' => "button"]) ?>

    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success', 'onclick' => 'almacenar()']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript">
  function almacenar() { // obtiene el id del dropDownList seleccionado al enviar el formulario, lo almacena en la menoria y lo vuelve a selecionar al cargar el formulario
    var option = document.getElementById("option");
    var subOption = document.getElementById("subOption");
    sessionStorage.setItem("grupoMenu", option.value);
    sessionStorage.setItem("subGrupoMenu", subOption.value);
  }

  if (sessionStorage.getItem("grupoMenu") != null) {
    document.getElementById("option").value = sessionStorage.getItem("grupoMenu");
  cambiarSubgrupos();
  document.getElementById("subOption").value = sessionStorage.getItem("subGrupoMenu");

  }

  function cambiarSubgrupos() {
    var option = document.getElementById("option");
    $("#subOption").find('option').not(':first').remove();
    $("#subOption").val($("#subOption option:first").val());
    var array = [];
  <?php  if ($subGrupos != null) {
    foreach ($subGrupos as $key => $subGrupo) { ?>
      if ('<?= $subGrupo->restaurante_id ?>' == '<?=$usuario->id?>' && '<?=$subGrupo->grupo_id?>' == option.value ) { 
      document.getElementById("subOption").innerHTML += "<option value='" + '<?=$subGrupo->id?>' + "'>" + '<?=$subGrupo->nombre?>' + "</option>";
    }
   <?php }  } else{ ?>
    $("#subOption").val($("#subOption option:first").val());
    <?php }  ?>

  }

  function validarClic(e) { //impide la entrada por teclado en un input
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8) return true; //Tecla de retroceso (para poder borrar)
    //if (tecla == 44) return true; //Coma ( En este caso para diferenciar los decimales )
    if (tecla == 48) return true;
    if (tecla == 49) return true;
    if (tecla == 50) return true;
    if (tecla == 51) return true;
    if (tecla == 52) return true;
    if (tecla == 53) return true;
    if (tecla == 54) return true;
    if (tecla == 55) return true;
    if (tecla == 56) return true;
    if (tecla == 57) return true;
    patron = /1/; //ver nota
    te = String.fromCharCode(tecla);
    return patron.test(te);
  }
  /*function validarContinuar(){

  }

  var submitBtn = document.getElementById("submit");
    
    submitBtn.onclick = function (event) {
      var resultado = window.confirm('Desea continuar registrando menus?');
    if (resultado === true) {
      
    } else {

    }

    }; */
</script>