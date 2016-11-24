<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\customer\TemporarySite */

$this->title = 'Create Temporary Site';
$this->params['breadcrumbs'][] = ['label' => 'Temporary Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="temporary-site-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
