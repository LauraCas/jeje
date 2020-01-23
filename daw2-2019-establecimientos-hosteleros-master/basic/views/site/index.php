<?php
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\widgets\Menu;
use yii\widgets\ListView;
use app\models\Locales;
use app\models\LocalesSearch;
use app\models\Etiquetas;
use app\models\EtiquetasSearch;


use yii\widgets\Pjax;

$this->title = 'My Yii Application';

if(!isset($id_padre)) $id_padre = NULL;


?>

<?php $style= <<<CSS

.contenedor{     
   margin-left: 40px;     
   }


CSS;
 $this->registerCss($style);
?> 


<div class="site-index">


    <div>    
<!-- POR HACER: unificar las búsquedas en una sola barra -->
<?php 
                    echo \Yii::$app->view->renderFile('@app/views/site/menu.php', [
                        'filtro'=> $filtro,
                    ]);
                ?>

</div>

    <div class="contenedor">
   
    <?php if($filtro == 1){?>
        <h4> Búsqueda simple </h4>
                <?php 
                    echo \Yii::$app->view->renderFile('@app/views/locales/_busquedaSimple.php', [
                        'model'=> new Locales(),
                    ]);
                ?>
    <?php } ?>
        
        <?php if($filtro == 2){?>
        <h4> Búsqueda avanzada </h4>
             </br>  
              <?php 
                    echo \Yii::$app->view->renderFile('@app/views/locales/busquedaavanzada.php', [
                        'model'=> new Locales(),
                    ]);
                ?>
        <?php } ?>
        
        
        <?php if($filtro == 3){?>
             <h4> Búsqueda por categorías </h4>
             </br>
                 <?php 
                echo \Yii::$app->view->renderFile('@app/views/locales/_busquedaCategorias.php', [
                        'model'=> new Locales(),
                        'id_padre' => $id_padre
                ]);
            ?>
        <?php } ?>
        
        <?php if($filtro == 4){?>
        <h4> Nube de etiquetas </h4>
         </br>
            <div id="etiquetas">
                <div class="card-block">
                    <?php 
                        echo \Yii::$app->view->renderFile('@app/views/etiquetas/_busquedaEtiquetas.php');
                    ?>
                </div>
            </div>
        <?php } ?>
       
    </div>


    <br>

    <div class="container">
        <?php 

        //Aquí no hay que poner ningún GRIDVIEW. Esta parte se hace con un LISTVIEW a la espera de la pieza ficha resumida de los locales.

        Pjax::begin(); 
        //echo "**Faltaría ficha resumen para mostrar los resultados";
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => 'locales_mini', //pieza que me tiene que pasar otro grupo de la ficha resumida
            'layout' => '<div class="container container-fluid">{items}</div> <div>{pager}{summary}</div>',

        ]);  

        Pjax::end(); ?>
    </div>
</div>
