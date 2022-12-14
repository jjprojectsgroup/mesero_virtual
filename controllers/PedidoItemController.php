<?php

namespace app\controllers;

use app\models\Menu;
use app\models\Pedido;
use app\models\PedidoItem;
use app\models\Factura;
use app\models\Restaurante;
use app\models\search\MenuSearch;
use app\models\search\PedidoItemSearch;
use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PedidoItemController implements the CRUD actions for PedidoItem model.
 */
class PedidoItemController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['index', 'pedido', 'create', 'update'],
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'pedido', 'create', 'update'],
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all PedidoItem models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PedidoItemSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PedidoItem model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PedidoItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PedidoItem();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($pedido = $this->createPedido(0)) {
                    $model->pedido_id = $pedido->id;
                    $model->save();
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new PedidoItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionPedido()
    {
        $menuModel = new Menu();
        $restauranteId = Yii::$app->cache->get('restauranteId');

        $menuModel->restaurante_id = $restauranteId;

        $searchModel = new PedidoItemSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $searchMenuModel = new MenuSearch();
        $dataMenuProvider = $searchMenuModel->search($this->request->queryParams);
        return $this->render('pedido', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchMenuModel' => $searchMenuModel,
            'dataMenuProvider' => $dataMenuProvider,
            'menuModel' => $menuModel,

        ]);
    }

    function actionGenerarPedido()
    {
        $pedido = new Pedido();
        $restaurante = Restaurante::findOne(['usuario_id' => Yii::$app->user->identity->id]);
        $pedido->restaurante_id = $restaurante->id;
        $pedido->cliente_id = '';
        $pedido->valor = 10000;
        $pedido->estado = 'activo';
        if ($pedido->save(false)) {
            /* Yii::$app->cache->get('tipoPlato');
            $pedidoItem->pedido_id=$pedido->id;
            $pedidoItem->menu_id = 5;
            $pedidoItem->cantidad=10;
            $pedidoItem->valor= 15000;
            $pedidoItem->save(false);*/
            //$this->menu();
            Yii::$app->session->setFlash('info', 'Pedido registrado exitosamente');
            return $this->actionMenu();
        } else {
            Yii::$app->session->setFlash('info', 'El pedido no se pudo registrar');
            // return false;
        }
    }

    public function actionGrupo($id, $nombre)
    {
        $restauranteId = Yii::$app->cache->get('restauranteId');

        $menu = Menu::find()->where(['restaurante_id' => $restauranteId, 'grupo' => $id])->all();
        $nombre = explode("-", $nombre);
        Yii::$app->cache->set('tipoPlato', $nombre[0]);
        $pedidoItem = new PedidoItem();
        if ($this->request->isPost) {
            if ($pedidoItem->load($this->request->post())) {
                $pedidoItem->pedido_id = 1;
                Yii::$app->cache->set('menuPlatos' . $pedidoItem->menu_id, $pedidoItem);
                //$pedidoItem->save(false);
                //return $this->redirect(['pedido/view', 'id' => 1]);
            }
        }
        return $this->render('create_pedido', [
            'pedidoItem' => $pedidoItem,
            'menu' => $menu,
        ]);
    }

    public function actionMenu()
    {

        if (isset($_GET["id"])) {
            Yii::$app->cache->set('restauranteId', $_GET["id"]);
            //echo '<script> alert("Primero debe selecionar algun item del menu para poder generar el pedido"); </script>';
        }

        if (Yii::$app->cache->get('restauranteId') != null) {
            $restaurante = Restaurante::findOne(['id' => Yii::$app->cache->get('restauranteId')]);
            if (isset($restaurante->activado)) {
                if ($restaurante->activado == '1') {
                    $restauranteId = Yii::$app->cache->get('restauranteId');

                    $model = new Menu();
                    $model->restaurante_id = $restauranteId;

                    return $this->render('Menu', [
                        'model' => $model,
                    ]);
                } else {
                    throw new NotFoundHttpException('El restaurante solicitado no se encuentra activo.');
                }
            } else {
                throw new NotFoundHttpException('el restaurante solicitado no se encuentra registrado.');
            }
        } else {
            throw new NotFoundHttpException('Enlace no valido.');
        }
    }

    public function actionFacturar()   // almacena el pedido del cliente en base de datos
    {
        $usuario = Restaurante::findOne(['id' => Yii::$app->cache->get('restauranteId')]);


        $menuFinal = new Factura();
        $pedido = new Pedido();

        if ($this->request->isPost) {
            if ($menuFinal->load($this->request->post())) {

                $menu_id = explode("-", $menuFinal->menu_id);
                $cantidad = explode("-", $menuFinal->cantidad);
                $valor = explode("-", $menuFinal->valor);

                if (array_sum($valor) > 0 && $pedido = $this->createPedido(array_sum($valor))) {
                    foreach ($menu_id as $key => $item) {
                        $pedidoItem = new PedidoItem();
                        if ($key != count($menu_id) - 1) {
                            $pedidoItem->pedido_id = $pedido->id;
                            $pedidoItem->menu_id = $menu_id[$key];
                            $pedidoItem->cantidad = $cantidad[$key];
                            $pedidoItem->valor = $valor[$key];
                            $pedidoItem->save(false);
                        }
                    }

                    Yii::$app->cache->set('restauranteProvicional', Yii::$app->cache->get('restauranteId'));
                    Yii::$app->cache->delete('restauranteId');
                    return $this->redirect(['pedido/view', 'id' => $pedido->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Primero debe selecionar algun item del menu para poder generar el pedido');
                    //echo '<script> alert("Primero debe selecionar algun item del menu para poder generar el pedido"); </script>';
                }
            }
        } else {
            //   $menuFinal->loadDefaultValues();
        }

        return $this->render('factura', [
            'menuFinal' => $menuFinal,
            'usuario' => $usuario,

        ]);
    }

    public function actionMenuPrincipal()
    {
        return $this->render('pedido');
    }

    function createPedido($valor)
    {
        $pedido = new Pedido();
        $restaurante = Restaurante::findOne(['id' => Yii::$app->cache->get('restauranteId')]);
        $pedido->restaurante_id = $restaurante->id;
        $pedido->cliente_id = '';
        $pedido->valor = $valor;
        $pedido->estado = 'Activo';
        if ($pedido->save(false)) {
            /* Yii::$app->mailer->compose()
                ->setFrom('jrbgoye@gmail.com')
                ->setTo('boada1997@gmail.com')
                ->setSubject('Email sent from Yii2-Swiftmailer')
                ->send(); */
            /*   Yii::$app->mailer->compose()
                ->setTo("jrbgoye@gmail.com")
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
              //  ->setReplyTo([$this->email => $this->name])
                ->setSubject('Prueba2')
                ->setTextBody('esto es una prueba para facturacion')
                ->send();*/
            /*     Yii::$app->mailer->compose()
                ->setFrom('boada1997@gmail.com')
                ->setTo('jrbgoye@gmail.com')
                ->setSubject('Prueba')
                ->setTextBody('esto es una prueba para facturacion')
                ->setHtmlBody('<b>Contenido HTML</b>')
                ->send();*/
            return $pedido;
        } else {
            return false;
        }
    }

    /**
     * Updates an existing PedidoItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PedidoItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PedidoItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PedidoItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PedidoItem::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
