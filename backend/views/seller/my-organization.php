<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\customer\CustomerRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Organization';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seller-index">
    <?php
        if ($seller_user_id != Yii::$app->user->id){
    ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php
        } else {
    ?>
    <h1><?= Html::encode('My ' . $this->title) ?></h1>
    <?php 
        }
    ?>
    <p>
        <?= Html::a('Create 1st-Level Seller', ['create'], ['class' => 'btn btn-success']) ?>
        <?php
        if ($seller_user_id != Yii::$app->user->id){
            echo Html::a('Go Back', ['seller/my-organization', 
                    'seller_user_id' => $parent_seller_id
                    ], ['class' => 'btn btn-success']);
        }
        ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'userLink',
                'label' => 'Username',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->sellerOrganization;
                }
            ],
            'user_id',
            'rank_value',
            'rank_date',
            'total_points',
            'credits',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Html::tag('span','Detail'),
                'template' => '{view}',
            ],
        ],
    ]); ?>
</div>
<?php
$this->registerJs(
    "$(document).on('click', '#seller-organization', (function() {
        $.get(
            $(this).data('url'),
            function (data) {
                $('.modal-body').html(data);
                $('#modal').modal();
            }
        );
    }));"
); ?>
 
<?php
Modal::begin([
    'id' => 'modal',
    'header' => '<h4 class="modal-title">Seller\'s Organization 1st level</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Cerrar</a>',
]);
 
echo "<div class='well'></div>";
 
Modal::end();
?>