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
$nombreGrupos = null;
foreach ($grupos as $key=>$grupo) {
  $nombreGrupos[$grupo->id] = $grupo->nombre;
}
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

  <?= $form->field($model, 'grupo')->dropDownList($nombreGrupos, ['prompt' => 'Seleccione un Grupo', 'id'=>'option', 'onchange'=>'almacenar()']) ?>

  <!--  <?= $form->field($model, 'restaurante_id')->textInput() ?>-->

  <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

  <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

  <?= $form->field($model, 'precio')->textInput(['type'=>'number', 'min'=>0, 'onkeypress' => 'return validarClic(event)']) ?>

  <!--  <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'hora')->textInput(['maxlength' => true]) ?> -->

    <div class="form-group">
        <p></p>
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success', 'onclick'=>'almacenar()']) ?>
    </div>

  <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
  function almacenar() { // obtiene el id del dropDownList seleccionado al enviar el formulario, lo almacena en la menoria y lo vuelve a selecionar al cargar el formulario
    var option= document.getElementById("option");
  sessionStorage.setItem("grupoMenu", option.value);
  }

  if(sessionStorage.getItem("grupoMenu")!=null){
  document.getElementById("option").value=sessionStorage.getItem("grupoMenu"); 
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