<?php

use app\models\Restaurante;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\RestauranteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Restaurantes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurante-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Restaurante', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nit',
            'nombre',
            'telefono',
            'celular',
            //'email:email',
            //'encargado',
            //'direccion',
            //'ciudad',
            //'total_mesas',
            //'mensualidad',
            //'codigo_de_activacion',
            //'activado',
            //'usuario_id',
            //'fecha',
            //'hora',
            //'logo',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],

        ],
    ]); ?>


</div>
<style>
    .page-link.active,
    .active>.page-link {
        background-color: #aec1dd;
    }
</style>