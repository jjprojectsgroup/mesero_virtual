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
    <div   class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold"><?php echo $model->nombre ?></span><span class="text-black-50"><?php echo $model->email ?></span><span> </span></div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Configuración de Perfil</h4>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6"><label class="labels">Nit</label><?= $form->field($model, 'nit')->textInput()->label(false) ?></div>
                    <div class="col-md-6"><label class="labels">Nombre de Restaurante</label><?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label(false) ?></div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12"><label class="labels">Telefono</label><?= $form->field($model, 'telefono')->textInput()->label(false) ?></div>
                    <div class="col-md-12"><label class="labels">Celular</label><?= $form->field($model, 'celular')->textInput()->label(false) ?></div>
                    <div class="col-md-12"><label class="labels">Encargado</label><?= $form->field($model, 'encargado')->textInput(['maxlength' => true])->label(false) ?></div>
                    <div class="col-md-12"><label class="labels">Direccion</label><?= $form->field($model, 'direccion')->textInput(['maxlength' => true])->label(false) ?></div>
                    <div class="col-md-12"><label class="labels">Ciudad</label><?= $form->field($model, 'ciudad')->textInput(['maxlength' => true])->label(false) ?></div>
                    <?php if(Yii::$app->user->isGuest || $tipo!=null && $tipo=='1'  ){?>
                   
                   <div class="row mt-3">
                   <div class="col-md-6"><label class="labels">Mesas Totales</label><?= $form->field($model, 'total_mesas')->textInput()->label(false) ?></div>
                    <div class="col-md-6"><label class="labels">Mensualidad</label><?= $form->field($model, 'mensualidad')->textInput()->label(false) ?></div>
                  <div class="col-md-6"><label class="labels">Codigo de Activacion</label><?= $form->field($model, 'codigo_de_activacion')->textInput()->label(false) ?></div>
                    <div class="col-md-6"><label class="labels">Activado</label><?= $form->field($model, 'activado')->dropDownList($activado, ['readonly'=> $readonly])->label(false) ?></div>  
                  <div class="col-md-6"><label class="labels">Fecha de Registro</label><?= $form->field($model, 'fecha')->textInput(['readonly'=> $readonly])->label(false)->label(false) ?></div>
                    <div class="col-md-6"><label class="labels">Hora de Registro</label><?= $form->field($model, 'hora')->textInput(['maxlength' => true, 'readonly'=> $readonly])->label(false) ?></div>
                   </div>
                    <?php }?>
                </div>
               
                <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="button">Save Profile</button></div>
            </div>
        </div>
    
    </div>
</div>
</div>
</div>  

    <div class="form-group">
        <p></p>
        <?= Html::submitButton($boton, ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


   




</div>
