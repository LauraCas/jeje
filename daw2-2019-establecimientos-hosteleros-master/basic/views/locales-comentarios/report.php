<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Locales */

$this->title = 'Report Comentario: ' . $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Locales', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
?>
<div class="locales-report">

    <h1>HAS REPORTADO EL COMENTARIO </h1>

    <?php
    	//Aumenta en 1 el número de denuncias si se ha pulsado en el boton de report de la vista de la página
    	$model->num_denuncias = $model->num_denuncias + 1;
    	$model->update();
    ?>

    <p><strong>Nº denuncias:</strong> <span class="text-danger"><?= $model->num_denuncias ?></span></p>

    <?php
    	if($model->num_denuncias == 1)
    	{
    		$model->fecha_denuncia1 = date('Y-m-d h:i:s');
    		$model->update();
    	}
    	
    ?>

    <p><strong>Fecha de primera denuncia:</strong> <span class="text-danger"><?= $model->fecha_denuncia1 ?></span></p>

    <?php
        //Bloqueado por número de denuncias. Por ejemplo: 5.

        if($model->num_denuncias >= 5)
        {
            $model->bloqueado = "1";
            $model->update();

            //Notas de bloqueo
            $model->notas_bloqueo = "Bloqueado por numero de denuncias ";
            $model->update();

            if($model->num_denuncias == 5)
            {
                $model->fecha_bloqueo = date('Y-m-d h:i:s');
                $model->update();
            }
        }
    ?>

    <p><strong>Fecha de bloqueo:</strong> <span class="text-danger"><?= $model->fecha_bloqueo ?></span></p>
    <p><strong>Notas de bloqueo:</strong> <span class="text-danger"><?= $model->notas_bloqueo ?></span></p>

    <?= Html::a('Volver', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
</div>
