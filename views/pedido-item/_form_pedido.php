<?php

use app\models\Menu;
use app\models\PedidoItem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\PedidoItemSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$menu = Menu::findAll(['restaurante_id' => $menuModel->restaurante_id]);
$lista;
foreach($menu as $menus){
  $lista[]= $menus->id." - ".$menus->nombre;
}
$this->title = 'Pedido Items';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pedido-item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'pedido_id',
            'menu_id',
            'cantidad',
            'valor',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],
        ],
    ]); ?>


</div>

