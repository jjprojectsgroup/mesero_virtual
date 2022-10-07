<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SubGrupo $model */

$this->title = 'Actualizar Sub Grupo: ' . $model->nombre;
/*$this->params['breadcrumbs'][] = ['label' => 'Sub Grupos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';*/
?>
<div class="sub-grupo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
