	<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Locales */

$this->title = 'Update Locales: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Locales', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="locales-comentarios-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'local_id' => $local_id,
        'actualizar' => $actualizar,
        'comentario_id' => $comentario_id,
    ]) ?>

</div>