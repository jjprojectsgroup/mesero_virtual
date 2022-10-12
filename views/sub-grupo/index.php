<?php

use app\models\SubGrupo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\SubGrupoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Sub Grupos';
if(Yii::$app->user->identity->tipo=='0'){
    $columns = [['class' => 'yii\grid\SerialColumn'],/*'id',*/ 'nombre', 'grupo_id', 'restaurante_id',['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],];
    }elseif(Yii::$app->user->identity->tipo=='1'){	
    $columns = [['class' => 'yii\grid\SerialColumn'],/*'id',*/ 'nombre', 'grupo_id', /*'restaurante_id', */ ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],];
    }
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-grupo-index">
<br>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Sub Grupo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<br>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]); ?>


</div>
