<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\customer\ThemeRecord */

$this->title = 'Create Theme Record';
$this->params['breadcrumbs'][] = ['label' => 'Theme Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="theme-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
