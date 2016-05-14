<?php

use yii\helpers\Html;
use yii\grid\ListView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Add Customer', ['add'], ['class' => 'btn btn-success']) ?>
    </p>

<?php
/**
 * @var \yii\data\BaseDataProvider $records
 */
echo \yii\widgets\ListView::widget(
    [
        'options' => [
            'class' => 'list-view',
            'id' => 'search_results'
        ],
        'itemView' => '_customer',
        'dataProvider' => $records
    ]
);
