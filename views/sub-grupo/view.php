<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\SubGrupo $model */

$this->title = $model->id;
/*$this->params['breadcrumbs'][] = ['label' => 'Sub Grupos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
\yii\web\YiiAsset::register($this);
if(Yii::$app->user->identity->tipo=='0'){
    $columns = [/*'id',*/ 'nombre', 'grupo_id', 'restaurante_id',];
    }elseif(Yii::$app->user->identity->tipo=='1'){	
    $columns = [/*'id',*/ 'nombre', 'grupo_id', /*'restaurante_id', */];
    }
?>
<div class="sub-grupo-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Menú', ['sub-grupo/index'], ["class" => "btn btn-primary menuA", 'role' => "button"]) ?>

    <p></p>
  <!--  <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p> -->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $columns,
    ]) ?>

</div>
