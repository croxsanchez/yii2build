<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use backend\models\customer\WebsiteSearch;
use backend\models\customer\AddressRecord;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\customer\CustomerRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Create New Customer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'birth_date',
                'format' => ['date', 'dd-MM-Y'],
            ],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'header' => 'Addresses<span class="glyphicon glyphicon-expand"></span>',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column) {
                    $query = AddressRecord::find();
                    $query->where(['customer_id' => $model->id]);
                    $dataProvider = new ActiveDataProvider([
                        'query' => $query,
                    ]);
                    $dataProvider->sort->attributes['fullAddress'] = [
                        'asc' => ['street' => SORT_ASC],
                        'desc' => ['street' => SORT_DESC]
                    ];
                    
                    return Yii::$app->controller->renderPartial('_addresses',[
                       'dataProvider' => $dataProvider,
                    ]);
                }
            ],
            [
                'attribute' => 'phone',
                'label' => 'Phones',
                'format' => 'paragraphs',
                'value' => function ($model) {
                    $result = '';
                    foreach ($model->phones as $phone) {
                        $result .= $phone->fullPhone . "\n\n";
                    }
                    return $result;
                }
            ],
            [
                'attribute' => 'email',
                'label' => 'Emails',
                'format' => 'paragraphs',
                'value' => function ($model) {
                    $result = '';
                    foreach ($model->emails as $email) {
                        $result .= $email->fullEmail . "\n\n";
                    }
                    return $result;
                }
            ],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'header' => 'Websites<span class="glyphicon glyphicon-expand"></span>',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column) {
                    $searchModel = new WebsiteSearch();
                    $searchModel->customer_id = $model->id;
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                    
                    return Yii::$app->controller->renderPartial('_websites',[
                       'searchModel' => $searchModel,
                       'dataProvider' => $dataProvider,
                    ]);
                }
            ],
            'customer_type_id',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}',
            ],
        ],
    ]); ?>
</div>
