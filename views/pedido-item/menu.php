<?php

use app\models\Menu;
use app\models\Restaurante;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Menu $model */
/** @var yii\widgets\ActiveForm $form */
/** @var app\models\PedidoItem $pedidoItem */

$this->title = 'Mesero Virtual';
$restauranteId = 16;
$mesaId = 1;

$usuario = Restaurante::findOne(['usuario_id' => Yii::$app->user->identity->id]);

Yii::$app->cache->set('restauranteId', $restauranteId); // guardar $restauranteId en caché para así recuperarla la próxima vez
Yii::$app->cache->set('mesaId', $mesaId); // guardar $restauranteId en caché para así recuperarla la próxima vez

?>
<form action="form.php" method="post" id="form2">
  <div class="menu-form" ALIGN="center">
    <br />
    <h1><?= Html::encode($this->title) ?></h1>
    <br />
    <?= Html::a('Bebidas', ['pedido-item/pedido-bebidas'], ["class" => "btn btn-outline-secondary btn-lg menuA", 'role' => "button"]) ?> <br /><br />
    <?= Html::a('Entradas', ['pedido-item/pedido-entradas'], ["class" => "btn btn-outline-secondary btn-lg menuA", 'role' => "button"]) ?> <br /><br />
    <?= Html::a('Platos Fuertes', ['pedido-item/pedido-platos'], ["class" => "btn btn-outline-secondary btn-lg menuA", 'role' => "button"]) ?> <br /><br />
    <?= Html::a('Postres', ['pedido-item/pedido-postres'], ["class" => "btn btn-outline-secondary  menuA", 'role' => "button"]) ?> <br /><br /><br /><br /><br /><br />
    <?= Html::button('Factura', ["class" => "btn btn-outline-secondary  menuA",  'id'=>'BotonParaEsconder']) ?> <br /><br />

  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

  <br /><br /><br />
  <div class="panel_error" id="DivAEsconder" style="display: none;">
  <?= $this->render('_factura', [
        'usuario' => $usuario,
    ]) ?>
  </div>
  <br /><br /><br />

  <script type="text/javascript">
    $(function() {
      $("#BotonParaEsconder").click(function() {
        var div =document.getElementById("DivAEsconder");
        if(div.style.display=="none"){
          div.style.display="block";
        }else{
       div.style.display="none";
        }
      });
    });
  </script>

  <style>
    .menuA {
      font-size: 20px;
      font-family: sans-serif;
      width: 170px;
      height: 50px;
    }

  </style>

</form>