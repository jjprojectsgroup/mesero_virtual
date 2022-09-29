<?php

namespace app\controllers;

use app\models\Menu;
use app\models\Pedido;
use app\models\PedidoItem;
use app\models\Restaurante;
use app\models\search\MenuSearch;
use app\models\search\PedidoItemSearch;
use Yii;
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
                if($pedido=$this->createPedido()){
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
        $menuModel->restaurante_id = 36;

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

    function actionGenerarPedido(){
        $pedido = new Pedido();
        $restaurante = Restaurante::findOne(['usuario_id' => Yii::$app->user->identity->id]);
        $pedido->restaurante_id = $restaurante->id;
        $pedido->cliente_id = '';
        $pedido->valor = 10000;
        $pedido->estado = 'activo';
        if($pedido->save(false)){
            //$this->menu();
            Yii::$app->session->setFlash('exito', 'Pedido registrado exitosamente');
           return $this->actionMenu();
        }else{
            Yii::$app->session->setFlash('error', 'El pedido no se pudo registrar');
           // return false;
        }     
    }

    public function actionPedidoBebidas()
    {
        $model = Menu::find()->where(['restaurante_id' => 36, 'grupo'=>'1'])->all();

        Yii::$app->cache->set('tipoPlato', 'Bebidas');

        return $this->render('pedido', [
            'model' => $model,
        ]);
    }

    public function actionPedidoPlatos()
    {
        $model = Menu::find()->where(['restaurante_id' => 36, 'grupo'=>'2'])->all();
        Yii::$app->cache->set('tipoPlato', 'Platos Fuertes');
        return $this->render('pedido', [
            'model' => $model,
        ]);
    }  

    public function actionPedidoEntradas()
    {
        $model = Menu::find()->where(['restaurante_id' => 36, 'grupo'=>'3'])->all();
        Yii::$app->cache->set('tipoPlato', 'Entradas');
        return $this->render('pedido', [
            'model' => $model,
        ]);
    }    
  
    public function actionPedidoPostres()
    {
        $model = Menu::find()->where(['restaurante_id' => 36, 'grupo'=>'4'])->all();
        Yii::$app->cache->set('tipoPlato', 'Postres');
        return $this->render('pedido', [
            'model' => $model,
        ]);
    }    

    public function actionMenu()
    {
        $model = new Menu();
        $model->restaurante_id = 36;

        $searchModel = new PedidoItemSearch();

        return $this->render('Menu', [
            'model' => $model,
        ]);
    }
    public function actionMenuPrincipal(){
        return $this->render('pedido');
    }

    function createPedido(){
        $pedido = new Pedido();
        $restaurante = Restaurante::findOne(['usuario_id' => Yii::$app->user->identity->id]);
        $pedido->restaurante_id = $restaurante->id;
        $pedido->cliente_id = '';
        $pedido->valor = 10000;
        $pedido->estado = 'activo';
        if($pedido->save(false)){
            return $pedido;
        }else{
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
