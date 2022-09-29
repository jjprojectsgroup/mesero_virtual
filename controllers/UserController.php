<?php

namespace app\controllers;

use app\models\Cliente;
use app\models\Restaurante;
use app\models\User;
use app\models\search\UserSearch;
use mysqli;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessController;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
               /* 'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                    ],
                ],*/
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
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();

        setlocale(LC_ALL,"es_CO");

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->encriptarPassword($model->password);
                if($model->save()){
                    if($model->tipo=='0'){
                        return $this->redirect(['view', 'id' => $model->id]);
                    }elseif($model->tipo=='1'){
                        $restaurante = new Restaurante();
                        $restaurante->nit=0;
                        $restaurante->nombre='';
                        $restaurante->telefono=0;
                        $restaurante->celular=0;
                        $restaurante->email=$model->email;
                        $restaurante->encargado='';
                        $restaurante->direccion='';
                        $restaurante->ciudad='';
                        $restaurante->total_mesas=0;
                        $restaurante->mensualidad=0;
                        $restaurante->codigo_de_activacion=0;
                        $restaurante->activado=0;
                        $restaurante->usuario_id=$model->id;
                        $restaurante->fecha=date('Y-m-d');
                        $restaurante->hora=date('H:i:s');
                        
                        if ($restaurante->save(false)) {   
                            /*$conexion = new mysqli("localhost", "MeseroAdmin", "MeseroAdmin2022$", "mesero_virtual");
                            if ($conexion->connect_errno) {
                                echo "Falló la conexión con MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error;
                                exit();
                            }
                            $idRestaurante = htmlentities($restaurante->id,ENT_QUOTES,'utf-8');
                            $consulta="CREATE TABLE `restaurante#{$idRestaurante}` (
                                `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                `grupo` CHAR(52) NOT NULL,
                                `nombre` CHAR(52) NOT NULL,
                                `descripcion` CHAR(52) NOT NULL,
                                `precio` INT(11) NOT NULL DEFAULT '0',
                                `fecha` date NOT NULL,
                                `hora` CHAR(52) NOT NULL
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

                            if ($resultado = mysqli_query($conexion, $consulta))
                            {}
                            mysqli_close($conexion);*/
                            

                            $model->login();
                            return $this->redirect(['restaurante/update', 'id' => $restaurante->id]);
                        }
                    }elseif ($model->tipo=='2'){
                        $cliente = new Cliente();
                        $cliente->nombre = '';
                        $cliente->saldo = 0;
                        $cliente->fecha=date('Y-m-d');
                        $cliente->hora=date('H:i:s');
                        $cliente->usuario_id=$model->id;
                        if ($cliente->save(false)) {   
                            $model->login();
                            return $this->redirect(['cliente/update', 'id' => $cliente->id]);
                        }
                    }

                }
                $model->password='';
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
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
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        Restaurante::findOne(['usuario_id' => $id])->delete();
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
