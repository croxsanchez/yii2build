<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Identification Card Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="identification-card-record-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Identification Card Record', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'number',
            'customer_id',
            'identification_card_type_value',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
