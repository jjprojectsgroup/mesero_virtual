<?php

use app\models\Grupo;
use app\models\Menu;
use app\models\Restaurante;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Menu $model */
/** @var yii\widgets\ActiveForm $form */
/** @var app\models\PedidoItem $pedidoItem */

$this->title = 'Mesero Virtual';

$mesaId = 1;

Yii::$app->cache->set('mesaId', $mesaId); // guardar $mesaId en caché para así recuperarla la próxima vez
$grupos = Grupo::find()->where(['restaurante_id' => [Yii::$app->cache->get('restauranteId'), null]])->all();

?>
<form action="form.php" method="post" id="form2">
  <div class="menu-form" ALIGN="center">

    <br />
    <h1><?= Html::encode($this->title) ?></h1>
    <br />
    <?php foreach ($grupos as $grupo) { ?>
      <?php $items = $grupo->getMenus()->orderBy(['id' => SORT_DESC])->where(['restaurante_id' => Yii::$app->cache->get('restauranteId')])->all(); ?>
      <?php if ($items != null) { ?>
        <?= Html::a($grupo->nombre, ['/pedido-item/grupo', 'id' => $grupo->id, 'nombre' => $grupo->nombre], ["class" => "btn btn-outline-secondary btn-lg menuA", 'role' => "button"]) ?><br /><br />
      <?php  } ?>
    <?php  } ?>

    <br /><br /><br /><br /><br /><br />
    <?= Html::a('Ver Factura', ['pedido-item/facturar'], ["class" => "btn btn-primary menuA", 'role' => "button"]) ?>

  </div>
  <div>

  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

  <style>
    .menuA {
      font-size: 20px;
      font-family: sans-serif;
      width: 170px;
      height: 50px;
    }

  </style>

</form>