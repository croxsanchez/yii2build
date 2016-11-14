<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\customer\Website */

$this->title = 'Update Website: ' . $model->description;
$this->params['breadcrumbs'][] = ['label' => 'Websites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="website-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_send_to_development', [
        'model' => $model,
        'customer_id' => $customer_id,
        'domain' => $domain,
        'dataProvider' => $dataProvider,
    ]) ?>

</div>
