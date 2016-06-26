<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Identification Card Initial Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="identification-card-initial-record-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Identification Card Initial Record', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'value',
            'initial',
            'identification_card_type_value',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
