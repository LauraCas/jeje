<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\user;

use app\models\Zonas;
use app\models\Categorias;

use app\widgets\ListarImagenes;

/* @var $this yii\web\View */
/* @var $model app\models\Locales */

//$this->title = $model->id;
$this->title = $dataProvider->id;
/*
	<?= DetailView::widget([
        'locales' => $locales,
        'attributes' => [
            //'id',

        ],

    ])
	?>
*/

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Locales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="locales-view">

<?php $style= <<<CSS


.bienvenido{
  margin-top: 20vw;
  background-image: url("../images/miperfil4.jpg");
  background-repeat: no-repeat;
  background-size: 100%,100%;
    width: 100%;
    height: 9.8vw;
  margin-top: 2vw;
}


.imagenLocal{
	object-fit: cover;
	width: 100%;
	height: 300px;
	border-radius: 1.5%;
	
}

CSS;
 $this->registerCss($style);
?>

<style type="text/css">
  

</style>

    <h1><?= Html::encode($this->title) ?> </h1>
	
	<br>
	
	<div align="center">
		<?php echo Html::img(Yii::$app->request->baseUrl."/images/".$model->imagen_id,['class' => 'imagenLocal']); ?>
	</div>
	
	<br><br>

   
    <p style="display:inline;">
      
        <?php 
            if(!Yii::$app->user->isGuest){
                if(Yii::$app->user->identity->admin){
                  echo \Yii::$app->view->renderFile('@app/views/locales/menuLocales.php', [
                        'model'=> $model,
                    ]);  
            
            ?>
        
    <div style="float:right; margin-left: 5px;">
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Seguro que quieres eliminar este local?',
                'method' => 'post',
            ],
        ]) ?>

    </div>  
       

        <?php 
            }//es admin
          }//is guest
        ?>
    <div style="float:right; ">
		<?php
		if(!Yii::$app->user->isGuest){
			if($seguimientoLocal==NULL)
			{	?>
		
                  <?= Html::a('Seguir', ['seguir', 'local_id' => $model->id], ['class' => 'btn btn-primary']) ?>
				  <?php
				  //Html::a('Comentarios', ['locales-comentarios/index', 'id' => $model->id], ['class' => 'btn btn-primary'])
            }
			
			else
			{	?>
				  <?= Html::a('Dejar de seguir', ['dejarseguir', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
				  <?php
                  //echo Html::a(Yii::t('app', 'Dejar de seguir'), ['usuarios-locales/dejarSeguir', 'id' => $seguimientoLocal->id], ['class' => 'btn btn-default btn-danger']);
            }
		}
		?>
	
         <?= Html::a('Valorar', ['locales-comentarios/create', 'local_id' => $model->id, 'id' => 0, 'comentario_id' => 0, 'actualizar' => 0], ['class' => 'btn btn-primary']) ?>
        </div>
            </br></br>
        
		
		
		<?php
			// Parte para mostrar la zona.
			$zonaLocal = Zonas::getListaZonas();
			$nombreZona = $zonaLocal[$model->zona_id];
			
			// Parte para mostrar la categoría.
			$categoriaLocal = (Categorias::find()->where(['categoria_id'=>$model->categoria_id])->one())->nombre;
		?>
		
		
		<?php if ($model->bloqueado) { $bloqueado = "Cerrado"; } else {$bloqueado = "Abierto";  }?>
    </p>
	 <?php if($model->totalVotos != 0){?>
		<div class = "badge badge-secondary" style = "float:right; "> Valoracion: <?= $model->sumaValores/$model->totalVotos;  ?> </div>
	 <?php }?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'titulo:ntext',
            'descripcion:ntext',
            'lugar:ntext',
            'url:ntext',
			[
                    'attribute'=>'zona_id',
					'label' => 'Zona',
					'value' => $nombreZona,
            ],
			[
                    'attribute'=>'categoria_id',
					'label' => 'Categoría',
					'value' => $categoriaLocal,
            ],
            //'imagen_id',
            [
                    'attribute'=>'sumaValores',
					'label' => 'Valoración',
            ],
			[
                    'attribute'=>'totalVotos',
					'label' => 'Votos',
            ],
            //'hostelero_id', 
            //'prioridad',
            //'visible',
			/*
            [
                    'attribute'=>'terminado',
                    'value' =>'No',
            ],*/
            //'fecha_terminacion',
			[
                    'attribute'=>'num_denuncias',
					'label' => 'Denuncias',
            ],
            //'fecha_denuncia1',
			
            [
                    'attribute'=>'bloqueado',
					'label' => 'Estado',
                    'value' => $bloqueado,
            ],
            //'fecha_bloqueo',
            //'notas_bloqueo:ntext',
            //'cerrado_comentar',
            //'cerrado_quedar',
            //'crea_usuario_id',
            //'crea_fecha',
            //'modi_usuario_id',
            //'modi_fecha',
            //'notas_admin:ntext',
        ],

    ]) 
	?>
	
	</br>
	
	<?= ListarImagenes::widget(['message' => $dataProviderImagen]) ?>
	
	</br></br></br>

	<div style="float:right; ">
    <?= 
        //Añadir un boton de report
        Html::a('Denunciar', ['report', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Seguro que quieres denunciar este local?',
                'method' => 'post',
            ], 
    ]) ?>
	</div>

    <?= 
        // Ver los comentarios
        Html::a('Comentarios', ['locales-comentarios/index', 'id' => $model->id], ['class' => 'btn btn-primary'])
        
	
	

        // Ver los comentarios
        //Html::a('Imagenes', ['locales-imagenes/index', 'id' => $model->id], ['class' => 'btn btn-primary'])
	?>
         <?= Html::a('Añadir Imagenes', ['create_img', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
	
    <?= $this->render('form_extraccion',['model'=>$model]); ?>
	<br><br></br>
</div>
