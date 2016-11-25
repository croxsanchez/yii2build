<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\customer\CustomerRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Websites Assigned to a Designer';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="designer-website-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'website_id',
                'label' => 'Website Id',
            ],
            [
                'attribute' => 'websiteDescription',
                'label' => 'Website Description',
            ],
            [
                'attribute' => 'domainName',
                'label' => 'Domain Name',
            ],
            [
                'attribute' => 'designerName',
                'label' => 'Designer Name',
            ],
            
            
            //'paymentStatus',
            [
                'class' => \yii\grid\ActionColumn::className(),
                'header' => 'Assign Designer',
                'controller' => 'website',
                'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'update') {
                            return Url::toRoute(['designer-website/assign', 'id' => $model['website_id']]);
                        }
                    },
                'template' => '{update}',
            ],
        ],
    ]); ?>
</div>
