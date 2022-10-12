<?php

use app\models\Menu;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PedidoItem $pedidoItem */
/** @var app\models\Menu $menu */

$this->title = 'Crear Pedido Item';
//$this->params['breadcrumbs'][] = ['label' => 'Pedido Items', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;

?>
<div class="pedido-item-create_pedido">


    <?= $this->render('_pedido', [
        'pedidoItem' => $pedidoItem,
        'menu' => $menu,
    ]) ?>

</div>
