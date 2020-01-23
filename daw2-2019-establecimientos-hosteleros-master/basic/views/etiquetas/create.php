<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Etiquetas */

$this->title = Yii::t('app', 'Crear Etiquetas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Etiquetas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="etiquetas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
