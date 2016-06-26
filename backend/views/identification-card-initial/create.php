<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\customer\IdentificationCardInitialRecord */

$this->title = 'Create Identification Card Initial Record';
$this->params['breadcrumbs'][] = ['label' => 'Identification Card Initial Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="identification-card-initial-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
