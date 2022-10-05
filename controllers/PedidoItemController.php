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
                if ($pedido = $this->createPedido()) {
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
            Yii::$app->session->setFlash('exito', 'Pedido registrado exitosamente');
            return $this->actionMenu();
        } else {
            Yii::$app->session->setFlash('error', 'El pedido no se pudo registrar');
            // return false;
        }
    }

    public function actionPedidoBebidas()
    {
        $pedidoItem = new PedidoItem();
        $menu = Menu::find()->where(['restaurante_id' => 36, 'grupo' => '1'])->all();

        Yii::$app->cache->set('tipoPlato', 'Bebidas');
        if ($this->request->isPost) {
            if ($pedidoItem->load($this->request->post())) {
                $pedidoItem->pedido_id=1; 
                Yii::$app->cache->set('menuBebidas'.$pedidoItem->menu_id, $pedidoItem);         
                //$pedidoItem->save(false);
                return $this->redirect(['/pedido-item/menu']);
                
            }
        }
        return $this->render('create_pedido', [
            'pedidoItem' => $pedidoItem,
            'menu' => $menu,
        ]);
    }

    public function actionPedidoPlatos()
    {
        $pedidoItem = new PedidoItem();
        $menu = Menu::find()->where(['restaurante_id' => 36, 'grupo' => '2'])->all();
        Yii::$app->cache->set('tipoPlato', 'Platos Fuertes');
        if ($this->request->isPost) {
            if ($pedidoItem->load($this->request->post())) {
                $pedidoItem->pedido_id=1; 
                Yii::$app->cache->set('menuPlatos'.$pedidoItem->menu_id, $pedidoItem);         
                //$pedidoItem->save(false);
                //return $this->redirect(['pedido/view', 'id' => 1]);
            }
        }
        return $this->render('create_pedido', [
            'pedidoItem' => $pedidoItem,
            'menu' => $menu,
        ]);
    }

    public function actionPedidoEntradas()
    {
        $menu = Menu::find()->where(['restaurante_id' => 36, 'grupo' => '3'])->all();
        Yii::$app->cache->set('tipoPlato', 'Entradas');
        $pedidoItem = new PedidoItem();
        if ($this->request->isPost) {
            if ($pedidoItem->load($this->request->post())) {
                $pedidoItem->pedido_id=1; 
                Yii::$app->cache->set('menuPlatos'.$pedidoItem->menu_id, $pedidoItem);         
                //$pedidoItem->save(false);
                //return $this->redirect(['pedido/view', 'id' => 1]);
            }
        }
        return $this->render('create_pedido', [
            'pedidoItem' => $pedidoItem,
            'menu' => $menu,
        ]);
        
    }

    public function actionPedidoPostres()
    {
        $menu = Menu::find()->where(['restaurante_id' => 36, 'grupo' => '4'])->all();
        Yii::$app->cache->set('tipoPlato', 'Postres');
        $pedidoItem = new PedidoItem();
        if ($this->request->isPost) {
            if ($pedidoItem->load($this->request->post())) {
                $pedidoItem->pedido_id=1; 
                Yii::$app->cache->set('menuPlatos'.$pedidoItem->menu_id, $pedidoItem);         
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
        $model = new Menu();
        $model->restaurante_id = 36;
      
        $searchModel = new PedidoItemSearch();

        return $this->render('Menu', [
            'model' => $model,

        ]);
    }

    public function actionFacturar(){
        $usuario = Restaurante::findOne(['usuario_id' => Yii::$app->user->identity->id]);

        $menuFinal = new Factura();

          $model = new PedidoItem();
          if ($this->request->isPost) {
              if ($menuFinal->load($this->request->post())) {
              //  if (Model::loadMultiple($menuFinal,Yii::$app->request->post())) {
                 // if ($pedido = $this->createPedido()) {
                 //   $menuFinal->pedido_id = $pedido->id;
                 $menu_id = explode("-", $menuFinal->menu_id);
                 $cantidad = explode("-", $menuFinal->cantidad);
                 $valor = explode("-", $menuFinal->valor);
                /* $data="11111111111111111111";
                 $console = 'console.log(' . json_encode($menu_id) . ');';
                 $console = sprintf('<script>%s</script>', $console);
                 echo $console;*/
                 //echo '<script> console.log("holaaaaaaaaaaaaaaaaaaaa"); </script>';
                 //   Yii::$app->cache->set('variancePositions', $menu_id[2]);
                 

                    //  $menuFinal->save();
                 // }
                //  return $this->redirect(['view', 'id' => $menuFinal->id]);
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

    function createPedido()
    {
        $pedido = new Pedido();
        $restaurante = Restaurante::findOne(['usuario_id' => Yii::$app->user->identity->id]);
        $pedido->restaurante_id = $restaurante->id;
        $pedido->cliente_id = '';
        $pedido->valor = 10000;
        $pedido->estado = 'activo';
        if ($pedido->save(false)) {
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
