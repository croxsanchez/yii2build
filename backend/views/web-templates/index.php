<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Web Template Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="web-template-record-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Web Template Record', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'theme_id',
            'template_purpose_value',
            'path',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
