<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Zonas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zonas-form">

    <?php $form = ActiveForm::begin();?>

    <?=$form->field($model, 'clase_zona_id')->dropDownList($model->getListaZonas());?>

    <?=$form->field($model, 'nombre')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'zona_id')->textInput()?>

    <div class="form-group">
        <?=Html::submitButton('Save', ['class' => 'btn btn-success'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
