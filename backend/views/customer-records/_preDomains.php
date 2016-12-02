<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\customer\PreDomainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="pre-domain-index">

        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //'id',
            'name',
            //'website_id',
            //'customer_id',
            'domainChoiceOrder',
            // 'domain_status_value',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',
        ],
    ]); ?>
</div>
