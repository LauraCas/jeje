<?php

namespace app\controllers;

use Yii;
use app\models\UsuariosAvisos;
use app\models\AvisosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\perfilSearch;
use app\models\hosteleros;
use app\models\localesSearch;
use app\models\LocalesComentariosSearch;
/**
 * AvisosController implements the CRUD actions for UsuariosAvisos model.
 */
class AvisosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all UsuariosAvisos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AvisosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UsuariosAvisos model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UsuariosAvisos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UsuariosAvisos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionCreatenotificacionadmin()
    {
        $model = new UsuariosAvisos();

        $model->fecha_aviso=date("Y-m-d h:i:s");
        $model->clase_aviso_id="C";
        $model->destino_usuario_id=1;
        $model->origen_usuario_id=Yii::$app->user->id;

        $searchModelPerfil = new perfilSearch();
            $IDUsuarioConectado=Yii::$app->user->id;   //cuando se decida como llamar a esta variable hay que cambiarlo deberia ser una variable de sesion o algo
            $hostelero = Hosteleros::find()->hostelero($IDUsuarioConectado)->count();
            $dataProviderPerfil = $searchModelPerfil->search(Yii::$app->request->queryParams,$IDUsuarioConectado);


            $searchModelPerfil2 = new avisosSearch();
            $dataProviderPerfil2 = $searchModelPerfil2->searchIDAvisosNovistos(Yii::$app->request->queryParams,$IDUsuarioConectado);
            $avisos=$dataProviderPerfil2->getTotalCount();


            $searchModelPerfil3 = new localesSearch();
            $localesSinValidar=($searchModelPerfil3->searchLocalesPendientesDeAceptacion(Yii::$app->request->queryParams,$IDUsuarioConectado))->getTotalCount();

            $searchModelPerfil4 = new LocalesComentariosSearch();
            $comentariosSinValidar=($searchModelPerfil4->searchPeticiones(Yii::$app->request->queryParams,$IDUsuarioConectado))->getTotalCount();


        if ($model->load(Yii::$app->request->post())) {
            $model->texto="*CONSULTA *".$model->texto;
            if($model->save()){
              return $this->redirect(['/perfil/index']);              
            }

        }


        return $this->render('NotificarAdmin', [
            'model' => $model,
             'dataProviderPerfil' => $dataProviderPerfil,
                'hostelero' => $hostelero,
                'avisos'=>$avisos,
                'localesSinValidar' => $localesSinValidar,
            'comentariosSinValidar' => $comentariosSinValidar, 

        ]);
    }

    /**
     * Updates an existing UsuariosAvisos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UsuariosAvisos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeletedesdeperfil($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['perfil/avisos']);
    }

    /**
     * Finds the UsuariosAvisos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UsuariosAvisos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsuariosAvisos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
