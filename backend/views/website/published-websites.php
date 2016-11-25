<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\customer\CustomerRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Published Websites';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="website-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'name',
                'label' => 'Domain Name',
            ],
            [
                'attribute' => 'description',
                'label' => 'Website Description',
            ],
            [
                'attribute' => 'customerName',
                'label' => 'Customer Name',
            ],
            'paymentStatus',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Update Info',
                'buttons' => [
                    'modify' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => Yii::t('app', 'Modify Website'),
                                    'data-confirm'=>'Are you sure you want to modify this website?',
                                    'data-method'=>'POST'
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'modify') {
                            return Url::toRoute(['published-site/modify-website','website_id' => $model['id']]);
                        }
                },
                'template' => '{modify}',
            ],
        ],
    ]); ?>
</div>
