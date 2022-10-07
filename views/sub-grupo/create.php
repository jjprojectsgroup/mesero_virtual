<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SubGrupo $model */

$this->title = 'Crear Sub Grupo';
//$this->params['breadcrumbs'][] = ['label' => 'Sub Grupos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-grupo-create">
<br>
    <h1><?= Html::encode($this->title) ?></h1>
<br>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
