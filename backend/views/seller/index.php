<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\bootstrap\Collapse;
use common\models\PermissionHelpers;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\SellerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sellers';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="seller-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php
if (PermissionHelpers::requireMinimumRole('Seller') && PermissionHelpers::requireStatus('Active')){
?>
    <p>
        <?= Html::a('Create Seller', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php
}
?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // 'id',
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute'=>'userIdLink', 'format'=>'raw'],
            ['attribute'=>'userLink', 'format'=>'raw'],
            ['attribute'=>'parentUserLink', 'format'=>'raw'],

            //'username',
            //'parentUsername',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
