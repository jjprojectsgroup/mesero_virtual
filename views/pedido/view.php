<?php

use app\models\Pedido;
use app\models\PedidoItem;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\data\ActiveDataProvider;
/** @var yii\web\View $this */
/** @var app\models\Pedido $model */
/** @var app\models\PedidoItem $item */

/** @var app\models\search\PedidoItemSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = $model->id;
/*$this->params['breadcrumbs'][] = ['label' => 'Pedidos', 'url' => ['index']];*/
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
//$item=PedidoItem::findOne(['pedido_id' => $model->id]);

    $query = PedidoItem::find()->where(['pedido_id' => $model->id]);


$provider = new ActiveDataProvider([
    'query' => $query,
    'pagination' => [
        'pageSize' => 10,
    ],
   /* 'sort' => [
        'defaultOrder' => [
            'created_at' => SORT_DESC,
            'title' => SORT_ASC,
        ]
    ],*/
]);
?>
<div class="pedido-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
      <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
       <!--  <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> -->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'restaurante_id',
            'cliente_id',
            'valor',
            'estado',
        ],
    ]) ?>
    
        <?= GridView::widget([
        'dataProvider' => $provider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
           // 'pedido_id',
            'menu_id',
            'cantidad',
            'valor',
          /*  [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, PedidoItem $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],*/
          //  ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}']
        ],
    ]); ?>


</div>
