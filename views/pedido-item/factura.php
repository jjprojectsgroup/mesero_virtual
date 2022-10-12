<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PedidoItem $model */
/** @var app\models\Factura $menuFinal */

$this->title = 'Facturar Pedido Item';
//$this->params['breadcrumbs'][] = ['label' => 'Pedido Items', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pedido-item-factura">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_factura', [
        'menuFinal' => $menuFinal,
        'usuario' => $usuario,
    ]) ?>

</div>
