<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\customer\CustomerIdentificationCard */

$this->title = 'Create Customer Identification Card';
$this->params['breadcrumbs'][] = ['label' => 'Customer Identification Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-identification-card-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
