<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\DesignerWebsite */

$this->title = $model->designer_id;
$this->params['breadcrumbs'][] = ['label' => 'Designer Websites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="designer-website-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'designer_id' => $model->designer_id, 'website_id' => $model->website_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'designer_id' => $model->designer_id, 'website_id' => $model->website_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'designer_id',
            'website_id',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
