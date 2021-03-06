<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\customer\DomainRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Domain Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="domain-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Domain Record', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'customer_id',
            'domain_choice_value',
            'payment_status_value',
            // 'domain_status_value',
            // 'theme_id',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',
            // 'payment_method_value',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
