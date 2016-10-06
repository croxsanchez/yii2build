
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
<?php 
echo Collapse::widget([
    'items' => [
            // equivalent to the above
            [
                'label' => 'Search',
                'content' => $this->render('_search', ['model' => $searchModel]) ,
                // open its content by default
                //'contentOptions' => ['class' => 'in']
            ],
        ]
    ]);
?>
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
        ['class' => 'yii\grid\SerialColumn'],
        //'id',
        ['attribute'=>'idLink', 'format'=>'raw'],
        ['attribute'=>'userLink', 'format'=>'raw'],
        ['attribute'=>'parentUserLink', 'format'=>'raw'],
        'rankName',
        ['attribute'=>'rank_date', 'format'=>'raw'],
        ['attribute'=>'total_points', 'format'=>'raw'],
        ['attribute'=>'credits', 'format'=>'raw'],

        //'username',
        //'parentUsername',

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
</div>