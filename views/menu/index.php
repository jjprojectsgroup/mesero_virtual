<?php

use app\models\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\MenuSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Menus';
$this->params['breadcrumbs'][] = $this->title;
if(Yii::$app->user->identity->tipo=='0'){
$columns = [['class' => 'yii\grid\SerialColumn'],/*'id',*/ 'grupo', 'restaurante_id', 'nombre', 'descripcion', 'precio'/*, 'fecha', 'hora', 'stock', 'estado', 'sub_grupo',*/,['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],];
}elseif(Yii::$app->user->identity->tipo=='1'){	
$columns = [['class' => 'yii\grid\SerialColumn'],/*'id',*/ 'grupo', 'sub_grupo', /*'restaurante_id',*/ 'nombre', 'descripcion', 'precio', 'stock', 'estado'/*, 'fecha', 'hora'*/,['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],];

}
?>
<div class="menu-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Yii::$app->user->identity->tipo=='1'?Html::a('Crear Menu', ['create'], ['class' => 'btn btn-success']):"" ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]); ?>


</div>
