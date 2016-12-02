<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\Url;
use backend\models\customer\PreDomainSearch;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\customer\CustomerRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sites Pending for First Payment';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="website-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
        $dataProvider->sort->attributes['description'] = [
                'asc' => ['description' => SORT_ASC],
                'desc' => ['description' => SORT_DESC]
            ];
    ?>
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
            [
                'attribute' => 'customerName',
                'label' => 'Customer\'s Name',
            ],
            [
                'attribute' => 'description',
                'label' => 'Website Description',
            ],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'header' => 'Pre-Domains',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column) {
                    $searchModel = new PreDomainSearch();
                    $searchModel->website_id = $model['id'];
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                    $dataProvider->sort->attributes['domainChoiceOrder'] = [
                        'asc' => ['domain_choice_value' => SORT_ASC],
                        'desc' => ['domain_choice_value' => SORT_DESC]
                    ];
                    
                    return Yii::$app->controller->renderPartial('_preDomains',[
                       'searchModel' => $searchModel,
                       'dataProvider' => $dataProvider,
                    ]);
                }
            ],
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
