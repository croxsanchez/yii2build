<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SellerIdentificationCard */

$this->title = 'Update Seller Identification Card: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Seller Identification Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="seller-identification-card-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
