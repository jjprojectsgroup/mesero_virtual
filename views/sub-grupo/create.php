<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SubGrupo $model */

$this->title = 'Create Sub Grupo';
//$this->params['breadcrumbs'][] = ['label' => 'Sub Grupos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-grupo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
