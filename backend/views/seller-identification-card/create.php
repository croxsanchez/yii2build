<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SellerIdentificationCard */

$this->title = 'Create Seller Identification Card';
$this->params['breadcrumbs'][] = ['label' => 'Seller Identification Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seller-identification-card-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
