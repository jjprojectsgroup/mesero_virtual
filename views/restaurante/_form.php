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

<div  class="restaurante-form">

<?php $form = ActiveForm::begin([
   'fieldConfig' => [
      'errorOptions' => [
           'encode' => false,
           'class' => 'help-block',
           'style'=>'color:red;',
       ],
   ],
   
]);?> 
    <div  class="container ">
    <div class="row">
        <div class="col-md-3 ">
            <div class="d-flex flex-column align-items-center text-center "><?= Html::img($model->logo,['width'=>'150px','class'=>'rounded-circle mt-5','onclick'=>'clicFoto()']) ?><span class="font-weight-bold"><p></p><?= $form->field($model, 'archivo')->fileInput(['id'=>'cargar','style'=>'display:none','onchange'=>'actualizarFoto()'])->label(false) ?><?php echo $model->nombre ?></span><span class="text-black-50"><?php echo $model->email ?></span><span> </span></div>
        
        </div>
        <div class="col-md-6 ">
            <div class="">
                <div >
                    <h3  class="text-center">Configuración de Perfil</h3>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6"><label class="labels">Nit</label><?= $form->field($model, 'nit')->input('number',['min' => 0, 'onkeypress' => 'return validarClic(event)'])->label(false) ?></div>
                    <div class="col-md-6"><label class="labels">Nombre de Restaurante</label><?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label(false) ?></div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12"><label class="labels">Telefono</label><?= $form->field($model, 'telefono')->input('number',['min' => 0, 'onkeypress' => 'return validarClic(event)'])->label(false) ?></div>
                    <div class="col-md-12"><label class="labels">Celular</label><?= $form->field($model, 'celular')->input('number',['min' => 0, 'onkeypress' => 'return validarClic(event)'])->label(false) ?></div>
                    <div class="col-md-12"><label class="labels">Encargado</label><?= $form->field($model, 'encargado')->textInput(['maxlength' => true])->label(false) ?></div>
                    <div class="col-md-12"><label class="labels">Direccion</label><?= $form->field($model, 'direccion')->textInput(['maxlength' => true])->label(false) ?></div>
                    <div class="col-md-12"><label class="labels">Ciudad</label><?= $form->field($model, 'ciudad')->textInput(['maxlength' => true])->label(false) ?></div>
                    <?php if($tipo!=null && $tipo=='0'  ){?>
                   
                   <div class="row mt-3">
                   <div class="col-md-6"><label class="labels">Mesas Totales</label><?= $form->field($model, 'total_mesas')->input('number',['min' => 0, 'onkeypress' => 'return validarClic(event)'])->label(false) ?></div>
                    <div class="col-md-6"><label class="labels">Mensualidad</label><?= $form->field($model, 'mensualidad')->input('number',['min' => 0, 'onkeypress' => 'return validarClic(event)'])->label(false) ?></div>
                  <div class="col-md-6"><label class="labels">Codigo de Activacion</label><?= $form->field($model, 'codigo_de_activacion')->textInput()->label(false) ?></div>
                    <div class="col-md-6"><label class="labels">Activado</label><?= $form->field($model, 'activado')->dropDownList($activado, ['readonly'=> $readonly])->label(false) ?></div>  
                  <div class="col-md-6"><label class="labels">Fecha de Registro</label><?= $form->field($model, 'fecha')->textInput(['readonly'=> $readonly])->label(false)->label(false) ?></div>
                    <div class="col-md-6"><label class="labels">Hora de Registro</label><?= $form->field($model, 'hora')->textInput(['maxlength' => true, 'readonly'=> $readonly])->label(false) ?></div>

                   </div>
                    <?php }?>
                </div>
               
                <div class="mt-5 text-center"> <?= Html::submitButton($boton, ['class' => 'btn btn-primary profile-button','id'=>'btnActualizar']) ?></div>
            </div>
        </div>
    
    </div>
    </div>


</div>  


    <?php ActiveForm::end(); ?>




</div>

<script type="text/javascript">
function clicFoto(){
    $('#cargar').click();

}
function actualizarFoto(){
    $('#btnActualizar').click();

}
function validarClic(e) { //impide la entrada por teclado en un input
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true; //Tecla de retroceso (para poder borrar)
    if (tecla==44) return true; //Coma ( En este caso para diferenciar los decimales )
    if (tecla==48) return true;
    if (tecla==49) return true;
    if (tecla==50) return true;
    if (tecla==51) return true;
    if (tecla==52) return true;
    if (tecla==53) return true;
    if (tecla==54) return true;
    if (tecla==55) return true;
    if (tecla==56) return true;
    if (tecla==57) return true;
    patron = /1/; //ver nota
    te = String.fromCharCode(tecla);
    return patron.test(te);
  }
</script>
