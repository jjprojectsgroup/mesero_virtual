<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PedidoItem $model */

$this->title = 'Actualizar Pedido Item: ' . $model->id;
/*$this->params['breadcrumbs'][] = ['label' => 'Pedido Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';*/
?>
<div class="pedido-item-update">
<br>
    <h1><?= Html::encode($this->title) ?></h1>
<br>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
