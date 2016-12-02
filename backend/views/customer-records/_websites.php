<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use backend\models\customer\PreDomainSearch;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\customer\WebsiteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="website-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //'id',
            //'customer_id',
            'description',
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column) {
                    $searchModel = new PreDomainSearch();
                    $searchModel->website_id = $model->id;
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
            //'theme_id',
            //'payment_method_value',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',
            // 'payment_status_value',
            // 'domain_id',
            // 'online_store:boolean',
            // 'social_media:boolean',
        ],
    ]); ?>
</div>
