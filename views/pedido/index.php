<?php

use app\models\Pedido;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\search\PedidoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Pedidos';
//$this->params['breadcrumbs'][] = $this->title;
$activado = ['Activo' => 'Activo', 'Cerrado' => 'Cerrado', 'Cerrado' => 'Cerrado'];
if (Yii::$app->user->identity->tipo == '0') {
    $columns = [['class' => 'yii\grid\SerialColumn'], 'id', 'restaurante_id', 'valor', 'estado', ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],];
} elseif (Yii::$app->user->identity->tipo == '1') {
    $columns = [['class' => 'yii\grid\SerialColumn'], 'id', 'valor', 'estado',  ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],];
}
Yii::$app->session->setFlash(
    'msg',
    '
     <div class="alert alert-success alert-dismissable">
     <strong>Atencion! </strong> Tienes nuevos pedidos.</div>'
);

?>
<div class="pedido-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!--  <p>
        <?= Html::a('Create Pedido', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <div id="divTabla">
        <div id="nuevoPedido" style="display: none;">
            <?= Yii::$app->session->getFlash('msg') ?>
        </div>
        <?php Pjax::begin(['id' => 'container']); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,

            'columns' => $columns,
        ]); ?>
        <?php Pjax::end(); ?>

    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    var valores = "";
    var actual = sessionStorage.getItem('pedidoActual');
    if (actual != $('table#table1 tr:eq(2) td:eq(1)').text()) {
                document.getElementById("nuevoPedido").style.display = "block";
                actual = $('table#table1 tr:eq(2) td:eq(1)').text();
                sessionStorage.setItem('pedidoActual', actual);
            }
    setInterval(function() {
        document.getElementById("nuevoPedido").style.display = "none";
        $.pjax.reload({
            container: '#container'
        });
        setInterval(function() {
            if (actual != $('table#table1 tr:eq(2) td:eq(1)').text()) {
                document.getElementById("nuevoPedido").style.display = "block";
                actual = $('table#table1 tr:eq(2) td:eq(1)').text();
                sessionStorage.setItem('pedidoActual', actual);
            }
        }, 1000);
        // console.log(actual);

    }, 20000);
</script>
<style>
    th.nombrecss {

        width: 100px;

    }
</style>