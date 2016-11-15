<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\DesignerWebsite */

$this->title = 'Create Designer Website';
$this->params['breadcrumbs'][] = ['label' => 'Designer Websites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="designer-website-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
