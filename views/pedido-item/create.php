<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PedidoItem $model */

$this->title = 'Create Pedido Item';
$this->params['breadcrumbs'][] = ['label' => 'Pedido Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pedido-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
