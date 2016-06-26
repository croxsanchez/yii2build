<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\customer\TemplatePurposeRecord */

$this->title = 'Create Template Purpose Record';
$this->params['breadcrumbs'][] = ['label' => 'Template Purpose Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-purpose-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
