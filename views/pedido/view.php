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

$this->title = 'Pedido'; //$model->id;
/*$this->params['breadcrumbs'][] = ['label' => 'Pedidos', 'url' => ['index']];*/
//$this->params['breadcrumbs'][] = $this->title;
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
    <br>
  <!--  <h1><?= Html::encode($this->title) ?></h1> -->


    <?php if (Yii::$app->user->identity != null && Yii::$app->user->identity->tipo == 1) { ?>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Menú', ['pedido/index'], ["class" => "btn btn-primary menuA", 'role' => "button"]) ?>

        <p>
            <!--  <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?> -->
        </p>
    <?php } ?>
    <p></p>
    <div id="seleccion">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                //    'restaurante_id',
                //'cliente_id',
                'valor',
                'estado',
            ],
        ]) ?>
        <br /><br />
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
    <?= Html::a('Imprimir', null, ["class" => "btn btn-secondary menuA", 'role' => "button", 'href' => 'javascript:imprSelec("seleccion")']) ?>
    <?= Html::a('Nuevo pedido', ['/pedido-item/menu'], ["class" => "btn btn-primary menuA", 'role' => "button", 'onclick' => Yii::$app->cache->set('restauranteId', Yii::$app->cache->get('restauranteProvicional'))]) ?>

</div>
<script type="text/javascript">
    function imprSelec(nombre) {
        var ficha = document.getElementById(nombre);
        var ventimp = window.open(' ', 'popimpr');
        ventimp.document.write(ficha.innerHTML);
        ventimp.document.close();
        ventimp.print();
        ventimp.close();
    }
</script>
<style>
    .page-link.active,
    .active>.page-link {
        background-color: #aec1dd;
    }
</style>