<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\perfil */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="perfil-form">

    <?php $form = ActiveForm::begin(['action' => 'index']); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <!--<?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>-->

    <?= $form->field($model, 'nick')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_nacimiento')->textInput() ?>

    <?= $form->field($model, 'direccion')->textarea(['rows' => 6]) ?>


    <div class="form-group">
        <?= Html::submitButton('Guardar datos', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
