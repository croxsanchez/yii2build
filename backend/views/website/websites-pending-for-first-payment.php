<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\customer\CustomerRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sites Pending for First Payment';
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
            //'customer_id',
            'customerName',
            [
                'attribute' => 'description',
                'label' => 'Website Description',
            ],
            'name',
            'domainChoiceOrder',
            'paymentStatus',
            [
                'class' => \yii\grid\ActionColumn::className(),
                'header' => 'Update Info',
                'controller' => 'website',
                'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'update') {
                            return Url::toRoute(['send-to-development', 'id' => $model['id']]);
                        }
                    },
                'template' => '{update}',
            ],
        ],
    ]); ?>
</div>
