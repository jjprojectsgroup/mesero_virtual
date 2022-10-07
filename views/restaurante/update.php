<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Restaurante $model */

$this->title = 'Actualizar Restaurante: ' . $model->id;
/*
$this->params['breadcrumbs'][] = ['label' => 'Restaurantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];*/
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="restaurante-update">
<br>
   <!--   <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
