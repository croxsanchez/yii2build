<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SellerPhone */

$this->title = 'Update Seller Phone: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Seller Phones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="seller-phone-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
