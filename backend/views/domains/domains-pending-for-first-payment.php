<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\customer\CustomerRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sites Pending for Payment';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'label' => 'Domain Id',
            ],
            'customer_id',
            'customerName',
            [
                'attribute' => 'name',
                'label' => 'Domain Name',
            ],
            'paymentStatus',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Update Info',
                'template' => '{update}',
            ],
        ],
    ]); ?>
</div>
