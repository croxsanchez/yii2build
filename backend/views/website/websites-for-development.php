<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\customer\CustomerRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Websites for Development';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="website-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'label' => 'Website Id',
            ],
            'customer_id',
            [
                'attribute' => 'customerName',
                'label' => 'Customer Name',
            ],
            [
                'attribute' => 'domainName',
                'label' => 'Domain Name',
            ],
            //'paymentStatus',
            [
                'class' => '\yii\grid\ActionColumn',
                'header' => 'Send to Design',
                'controller' => 'website',
                'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'update') {
                            return Url::toRoute(['send-to-design', 'id' => $model['id']]);
                        }
                    },
                'template' => '{update}',
            ],
        ],
    ]); ?>
</div>
