<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Categoria;
use app\models\Categorias;
use app\models\CategoriasSearch;
use app\models\CategoriasQuery;

if(!isset($id_padre)) $id_padre = 0;
if($id_padre != 0){

    $categoria = Categorias::find()->categoriaPadre($id_padre)->all();
    $nombrePadre = Categorias::findOne(['id' => $id_padre]);
    //echo $nombrePadre->nombre;
} 

?>

<div class="local-search">

    <?php $form = ActiveForm::begin([
        'action' => ['busquedacategoria'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?php

        //generar un array con todas las categorías indexadas.

            $categoria = Categorias::find()->categoriaPadre($id_padre)->all();
            //imprimir la query en formato SQL
            // echo $categoria->createCommand()->getRawSql();

            $categorialista=ArrayHelper::map($categoria,'id','nombre');    

        //generar input de tipo dropdown

            echo "<select name='id_padre'/>";


            if($id_padre == 0){//Si es la primera busqueda, indicamos que seleccione una categoria

                echo "<option value='' disabled selected>Selecciona una categoría</option>";

            }else{//sino, indicamos el nombre de la categoria padre

                echo "<option value='' disabled selected>".$nombrePadre->nombre."</option>";
            }
            
                foreach($categorialista as $id=>$nombre){

                    if($id_padre!=0) echo "<option value='".$id."' selected>".$nombre."</option>";
                    else echo "<option value='".$id."'>".$nombre."</option>";
                }

            echo "</select>";


        ?>


        <?= Html::submitButton(Yii::t('app', 'Buscar'), ['class' => 'btn btn-primary']) ?>

        <?php 

            if($id_padre != 0){

                echo Html::a('Atras', ['site/busquedacategoria', 'id_padre' => $nombrePadre->categoria_id], ['class' => 'btn btn-primary']); 

            }

        ActiveForm::end(); ?>

</div>
