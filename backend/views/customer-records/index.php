<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\customer\CustomerRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customer Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Customer Record', ['create'], ['class' => 'btn btn-success']) ?>
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
                'attribute' => 'domain',
                'label' => 'Domains',
                'format' => 'paragraphs',
                'value' => function ($model) {
                    $result = '';
                    foreach ($model->domains as $domain) {
                        $result .= $domain->fullDomain . "\n\n";
                    }
                    return $result;
                }
            ],
            [
                'class' => 'backend\utilities\AuditColumn',
                'attribute' => 'id'
            ],
            // 'id',
            // 'notes:ntext',
            'customer_type_id',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
