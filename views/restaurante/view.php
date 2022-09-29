<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Restaurante $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Restaurantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="restaurante-view">

    <h1><?= Html::encode($this->title) ?></h1>

 <!--   <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p> -->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nit',
            'nombre',
            'telefono',
            'celular',
            'email:email',
            'encargado',
            'direccion',
            'ciudad',
            'total_mesas',
            'mensualidad',
            'codigo_de_activacion',
            'activado',
            'usuario_id',
            'fecha',
           // 'hora',
        ],
    ]) ?>

</div>
