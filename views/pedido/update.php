<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Pedido $model */

$this->title = 'Actualizar Pedido: ' . $model->id;
/*$this->params['breadcrumbs'][] = ['label' => 'Pedidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';*/
?>
<div class="pedido-update">
<br>
    <h1><?= Html::encode($this->title) ?></h1>
<br>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
