<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\SellerPhoneSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Seller Phones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seller-phone-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Seller Phone', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'purpose',
            'number',
            'seller_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
