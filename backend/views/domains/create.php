<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\customer\DomainRecord */

$this->title = 'Create Domain Record';
$this->params['breadcrumbs'][] = ['label' => 'Domain Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="domain-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'customer_id' => $customer_id
    ]) ?>

</div>
