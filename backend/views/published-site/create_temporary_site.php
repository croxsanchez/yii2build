<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\customer\TemporarySite */

$this->title = 'Create Temporary Site';
$this->params['breadcrumbs'][] = ['label' => 'Temporary Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="published-site-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_create_temporary_site', [
        'model' => $model,
        'website_id'  => $website_id,
        'designer_id' => $designer_id,
        'seller_id' => $seller_id,
        'customer_id' => $customer_id,
    ]) ?>

</div>
