<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\models\Cliente;
use app\models\Restaurante;
use app\models\User;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => '@web/favicon.ico']);
$usuario=null;
if(!Yii::$app->user->isGuest){
    $tipo = Yii::$app->user->identity->tipo;
    $ruta='';
    $id=Yii::$app->user->identity->id;
    if($tipo=='0'){
        $ruta='/user/update';
    }elseif($tipo=='1'){
        $usuario = Restaurante::findOne(['usuario_id' => $id]);
        $id=$usuario->id;
        $ruta='/restaurante/update';
    }elseif($tipo=='2'){
        $usuario = Cliente::findOne(['usuario_id' => $id]);
        $id=$usuario->id;
        $ruta='/cliente/update';
    }
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    if(!yii::$app->user->isGuest){
      $restaurante =  Restaurante::findOne(['usuario_id' => $id]);
    }
    NavBar::begin([

        'brandLabel' => '<img src="img/logo.png" class="pull-left rounded-circle" width="40px" />'.Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
    echo '<div>';
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [

            ['label' => 'Home', 'url' => ['/site/index']],
            (!Yii::$app->user->isGuest && $tipo=='0')?(
            ['label' => 'Usuarios', 'url' => ['/user/index']]
            ):(""),
            (!Yii::$app->user->isGuest && $tipo=='0')?(
            ['label' => 'Restaurantes', 'url' => ['/restaurante/index']]
            ):(""),
            (!Yii::$app->user->isGuest && $tipo=='0')?(
            ['label' => 'Clientes', 'url' => ['/cliente/index']]
            ):(""),
            (!Yii::$app->user->isGuest && ($tipo=='1' || $tipo=='0'))?(
                ['label' => 'Menu', 'url' => ['/menu/index']]
            ):(""),
            (!Yii::$app->user->isGuest && ($tipo=='1' || $tipo=='0'))?(
                ['label' => 'Sub-Grupos', 'url' => ['/sub-grupo/index']]
            ):(""), 
            (!Yii::$app->user->isGuest && ($tipo=='1' || $tipo=='0'))?(
                ['label' => 'Grupos', 'url' => ['/grupo/index']]
            ):(""), 
            (!Yii::$app->user->isGuest && ($tipo=='1' || $tipo=='0'))?(
                ['label' => 'Pedidos', 'url' => ['/pedido/index']]
            ):(""),
         /*   (!Yii::$app->user->isGuest && ($tipo=='1' || $tipo=='0'))?(
                ['label' => 'Item Pedido', 'url' => ['/pedido-item/index']]
            ):(""),*/
          /*  (!Yii::$app->user->isGuest && ($tipo=='1' || $tipo=='0'))?(
                ['label' => 'Pedido Cliente', 'url' => ['/pedido-item/menu']]
            ):(""),*/
        //    ['label' => 'Contact', 'url' => ['/site/contact']],
        (!Yii::$app->user->isGuest)?(                
            ['label' => 'Perfil', 'url' => [$ruta, 'id' => $id]]
            ):(""),
            (!Yii::$app->user->isGuest)?(
            ['label' => $usuario!=null?$usuario->nombre!=null?'Cerrar Sesion ('.$usuario->nombre.')':'Cerrar Sesion (' .Yii::$app->user->identity->email . ')':'Cerrar Sesion (ADMIN)',
            'url' => 'javascript:clicModal();']
            ):(""),
        Yii::$app->user->isGuest
            ? ['label' => 'Login', 'url' => ['/site/login']]
            : '<li class="nav-item">'
                . Html::beginForm(['/site/logout'])
                . Html::submitButton(
                    $usuario!=null?$usuario->nombre!=null?'Cerrar Sesion ('.$usuario->nombre.')':'Cerrar Sesion (' .Yii::$app->user->identity->email . ')':'Cerrar Sesion (ADMIN)',
                    ['class' => 'nav-link btn btn-link logout', 'id'=>'logout','style'=>'display:none']
                )
                . Html::endForm()
                . '</li>',
        (Yii::$app->user->isGuest)?(                
            ['label' => 'Registro', 'url' => ['/user/create']]
            ):(""),
        ]
    ]);
    echo '</div>';
    echo '<div   >';
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav' ],
        'items' => [
    
                ]
    ]);
    echo '</div>';
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
         <!--   <div class="col-md-6 text-center text-md-start">&copy; JJProjects <?= date('Y') ?></div> 
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div> -->
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<script type="text/javascript">

function clicModal(){

    $('#btnModal').click();
   


//var alertaSesion = confirm("Estas seguro de cerrar sesion?");

//if(alertaSesion){

    //$('#logout').click();

//}else{
  //  window.location.href="index.html"
//}
 
}
function clicLogout(){

$('#logout').click();

}
</script>

<!-- Latest minified bootstrap css -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<!-- Latest minified bootstrap js -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<!-- Button to trigger modal -->
<label style="display:none" class="btn btn- btn-lg" id="btnModal" data-toggle="modal" data-target="#modalForm">
    Open Contact Form
</label>

<!-- Modal -->
<div class="modal fade" id="modalForm" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
          
                <h4 class="modal-title" id="myModalLabel"><strong>Estas seguro de cerrar sesion?</strong></h4>
            </div>
            

            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary submitBtn" onclick="clicLogout()">Aceptar</button>
            </div>
        </div>
    </div>
</div>