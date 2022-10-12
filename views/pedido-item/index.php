<?php

use app\models\PedidoItem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\PedidoItemSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Pedido Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pedido-item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Pedido Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'pedido_id',
            'menu_id',
            'cantidad',
            'valor',
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
