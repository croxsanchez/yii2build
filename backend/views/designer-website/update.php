<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DesignerWebsite */

$this->title = 'Update Designer Website: ' . $model->designer_id;
$this->params['breadcrumbs'][] = ['label' => 'Designer Websites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->designer_id, 'url' => ['view', 'designer_id' => $model->designer_id, 'website_id' => $model->website_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="designer-website-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
