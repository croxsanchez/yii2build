<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\customer\CustomerRecord */

$this->title = 'Create New Customer';
$this->params['breadcrumbs'][] = ['label' => 'Customer Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsAddress' => $modelsAddress,
        'modelsEmail' => $modelsEmail,
        'modelsPhone' => $modelsPhone,
    ]) ?>

</div>
