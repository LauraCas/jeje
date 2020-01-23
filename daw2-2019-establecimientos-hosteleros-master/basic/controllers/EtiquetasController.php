<?php

namespace app\controllers;

use Yii;
use app\models\UsuariosEtiquetas;
use app\models\Etiqueta;
use app\models\LocalesEtiquetas;
use app\models\EtiquetasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EtiquetasController implements the CRUD actions for Etiquetas model.
 */
class EtiquetasController extends Controller
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
     * Lists all Etiquetas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EtiquetasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Etiquetas model.
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
     * Creates a new Etiquetas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Etiqueta();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Etiquetas model.
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
     * Deletes an existing Etiquetas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        //Comprobamos si la etiqueta a borrar esta siendo usada por algun establecimiento
            if(LocalesEtiquetas::find()->where(['etiqueta_id'=>$id])->count()>0){//si esta siendo usada lo indicamos, no dejando eliminarla

                Yii::$app->session->setFlash('danger','No se puede eliminar una etiqueta que esta siendo usada');
                return $this->redirect(['index']);

            }else{//si no esta siendo usada, la eliminamos

                $this->findModel($id)->delete();
            }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Etiquetas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Etiquetas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionUnificacion()
    {
         $model = new Etiqueta();//usamos un modelo de etiquetas pero no guardaremos una etiqueta sino dos ids de etiqueta

        if ($model->load(Yii::$app->request->post())) {
            $idEliminar = $model->descripcion;
            $idConservar = $model->nombre;//el atributo nombre en esta ocasion nos servirá para guardar el id de la otra categoria
            if($idEliminar != $idConservar)
            {
                LocalesEtiquetas::updateAll(['etiqueta_id' => $idConservar], 'etiqueta_id = '.$idEliminar);     
                $this->findModel($idEliminar)->delete();
            }
            
            return $this->redirect(['index']);
        }
        $listaDeEtiquetas = Etiqueta::find()->all();
        $listaDeNombres = array();
        foreach($listaDeEtiquetas as $etiqueta)
        {
            $listaDeNombres[$etiqueta->id]=$etiqueta->nombre;
        }
        return $this->render('unificacion', [
            'model' => $model,
            'listaDeEtiquetas' => $listaDeNombres,
        ]);
    }

    /* 
    Funcion que recibe por el post las etiquetas elegidas en el formulario de a extraccion de etiquetas en la vista del local
    Añade la relacion entre el local y la etiqueta  si no existe la relación
    */
    public function actionExtraccion(){

        $post = Yii::$app->request->post();
        if(isset($post['idlocal'])){
            $idlocal=$post['idlocal'];
            unset($post['idlocal']);
            foreach ($post as $idEtiqueta => $value) {
               $m=LocalesEtiquetas::find()->where(['local_id'=>$idlocal,'etiqueta_id'=>$idEtiqueta])->one();
               if($m==null){
                  $m = new LocalesEtiquetas();
                  $m->local_id=$idlocal;
                  $m->etiqueta_id=$idEtiqueta;
                  $m->save();
                   
               }
            }

             return $this->redirect(['locales/view', 'id' =>$idlocal]);
        }
        
    }


    protected function findModel($id)
    {
        if (($model = Etiqueta::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
