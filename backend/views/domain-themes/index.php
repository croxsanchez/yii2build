<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Domain Theme Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="domain-theme-record-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Domain Theme Record', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'domain_id',
            'web_template_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
