<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SellerPhone */

$this->title = 'Create Seller Phone';
$this->params['breadcrumbs'][] = ['label' => 'Seller Phones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seller-phone-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
