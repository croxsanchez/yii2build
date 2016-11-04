<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SellerAddress */

$this->title = 'Create Seller Address';
$this->params['breadcrumbs'][] = ['label' => 'Seller Addresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seller-address-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
