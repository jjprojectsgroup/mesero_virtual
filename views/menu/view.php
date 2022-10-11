<?php

use yii\base\Model;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Menu $model */

$this->title = $model->id;
/*$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/    
\yii\web\YiiAsset::register($this);

?>
<div class="menu-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Yii::$app->user->identity->tipo=='1'?Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']):'' ?>
   <!--     <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            //'id',
            'grupo',
            'sub_grupo',
            'nombre',
            'descripcion',
            'precio',
           // 'fecha',
           // 'hora',
           'stock',
           'estado',
        ],
    ]) ?>

</div>
