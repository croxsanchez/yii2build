<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\customer\DomainThemeRecord */

$this->title = 'Create Domain Theme Record';
$this->params['breadcrumbs'][] = ['label' => 'Domain Theme Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="domain-theme-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
