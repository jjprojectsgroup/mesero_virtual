<?php

use app\models\Pedido;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\PedidoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Pedidos';
//$this->params['breadcrumbs'][] = $this->title;
$activado = [ 'Activo' => 'Activo', 'Cerrado' => 'Cerrado', 'Cerrado' => 'Cerrado'];

?>
<div class="pedido-index" id="div" >

    <h1><?= Html::encode($this->title) ?></h1>

  <!--  <p>
        <?= Html::a('Create Pedido', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'restaurante_id',
          //  'cliente_id',
            'valor',
            'estado',
           /* [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Pedido $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
            */
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],
        ],
    ]); ?>

</div>
<script type="text/javascript">

    setTimeout(function(){ $("#div").load("index.php?r=pedido%2Findex");}, 10000);

</script>