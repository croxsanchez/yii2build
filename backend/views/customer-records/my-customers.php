<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
                'attribute' => 'country',
                'label' => 'Addresses',
                'format' => 'paragraphs',
                'value' => function ($model) {
                    $result = '';
                    foreach ($model->addresses as $address) {
                        $result .= $address->fullAddress . "\n\n";
                    }
                    return $result;
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
                'attribute' => 'website',
                'label' => 'Websites',
                'format' => 'paragraphs',
                'value' => function ($model) {
                    $result = '';
                    foreach ($model->websites as $website) {
                        $result .= $website->fullWebsite . "\n\n";
                    }
                    return $result;
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
