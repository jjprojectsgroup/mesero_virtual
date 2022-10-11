<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Menu;
use app\models\Restaurante;
use app\models\search\MenuSearch;
use yii\data\ActiveDataProvider;
use yii\widgets\DetailView;
/** @var yii\web\View $this */
/** @var app\models\Menu $model */
/** @var app\models\search\MenuSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$usuario = Restaurante::findOne(['usuario_id' => Yii::$app->user->identity->id]);
$searchModel = new MenuSearch();

$columns = [['class' => 'yii\grid\SerialColumn'], 'id', 'grupo', 'nombre', 'descripcion', 'precio'/*, 'fecha', 'hora'*/,['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],];
$query = Menu::find()->where(['restaurante_id' => $usuario->id]);

$this->title = 'Crear Menú';
//$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;

    $provider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'pageSize' => 30,
        ],
        'sort' => [
            'defaultOrder' => [
                'id' => SORT_DESC,
            ]
        ],
    ]);
 /*   $provider->setSort([
        'attributes' => [
            'id' => [
                'asc' => ['id' => SORT_ASC],
                'desc' => ['id' => SORT_DESC],
                'default' => SORT_ASC
            ],
        ],
        'defaultOrder' => [
            'id' => SORT_DESC
        ]
    ]);*/
?>
<div class="menu-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
<p></p>
    
<?= GridView::widget([
        'dataProvider' => $provider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]); ?>


</div>
