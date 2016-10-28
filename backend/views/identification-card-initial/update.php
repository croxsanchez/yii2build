<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\IdentificationCardInitial */

$this->title = 'Update Identification Card Initial: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Identification Card Initials', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="identification-card-initial-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
