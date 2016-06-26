<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\customer\DomainChoiceRecord */

$this->title = 'Create Domain Choice Record';
$this->params['breadcrumbs'][] = ['label' => 'Domain Choice Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="domain-choice-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
