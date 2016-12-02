<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use backend\models\customer\CustomerRecordSearch;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\customer\WebsiteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="website-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'purpose',
                'label' => 'Purpose',
                'format' => 'paragraphs',
            ],
            'country', 'state', 'city', 
            [
                'attribute' => 'fullAddress',
                'label' => 'Address',
                'format' => 'paragraphs',
            ],
        ],
    ]); ?>
</div>
