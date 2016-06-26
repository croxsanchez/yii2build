<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\customer\WebTemplateRecord */

$this->title = 'Create Web Template Record';
$this->params['breadcrumbs'][] = ['label' => 'Web Template Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="web-template-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
