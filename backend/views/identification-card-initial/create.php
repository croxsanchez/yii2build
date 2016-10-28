<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\IdentificationCardInitial */

$this->title = 'Create Identification Card Initial';
$this->params['breadcrumbs'][] = ['label' => 'Identification Card Initials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="identification-card-initial-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
