<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\customer\PreDomain */

$this->title = 'Create Pre Domain';
$this->params['breadcrumbs'][] = ['label' => 'Pre Domains', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pre-domain-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
