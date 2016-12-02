<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\dialog\Dialog;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\customer\CustomerRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Websites for Development';
$this->params['breadcrumbs'][] = $this->title;

echo Dialog::widget([
   'libName' => 'krajeeDialogCust', // optional if not set will default to `krajeeDialog`
   'options' => ['draggable' => true, 'closable' => true], // custom options
]);
?>
<div class="website-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'label' => 'Website Id',
            ],
            'customer_id',
            [
                'attribute' => 'customerName',
                'label' => 'Customer Name',
            ],
            [
                'attribute' => 'domainName',
                'label' => 'Domain Name',
            ],
            //'paymentStatus',
            [
                'class' => '\yii\grid\ActionColumn',
                'header' => 'Action',
                'controller' => 'website',
                'buttons' => [
                    'modify' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-edit"></span>', $url, [
                                    'title' => Yii::t('app', 'Modify Website'),
                                    'data-confirm'=>'Are you sure you want to modify this website?',
                                    'data-method'=>'POST'
                        ]);
                    },
                    'toDesign' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-share"></span>', $url, [
                                    'title' => Yii::t('app', 'Send to design'),
                                    'data-confirm'=>'Are you sure you want to send this website to design?',
                                    'data-method'=>'POST'
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'toDesign') {
                            return Url::toRoute(['send-to-design','id' => $model['id']]);
                        } elseif ($action === 'modify') {
                            return Url::toRoute(['websites-for-development','seller_user_id' => Yii::$app->user->id]);
                        }
                    },
                'template' => '{modify} {toDesign}',
            ],
        ],
    ]); ?>
</div>

<?php
$js = <<< JS

$("#accion").on("click", function() {
                        krajeeDialog.confirm('Are you sure?', function(result){
                            if (result) {
                                alert('Great! You provided a reason: \n\n' + result);
                            } else {
                                alert('Oops! You declined to provide a reason!');
                            }
                    });
 });

JS;
 
// register your javascript
$this->registerJs($js);

?>