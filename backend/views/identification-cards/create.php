<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\customer\IdentificationCardRecord */

$this->title = 'Create Identification Card Record';
$this->params['breadcrumbs'][] = ['label' => 'Identification Card Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="identification-card-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
