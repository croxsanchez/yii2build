<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\dialog\Dialog;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\customer\CustomerRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'New Websites for Design';
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
                'attribute' => 'websiteDescription',
                'label' => 'Website Description',
            ],
            [
                'attribute' => 'domainName',
                'label' => 'Domain Name',
            ],
            [
                'attribute' => 'themeName',
                'label' => 'Theme Name',
            ],
            //'paymentStatus',
            [
                'class' => '\yii\grid\ActionColumn',
                'header' => 'Action',
                'controller' => 'website',
                'buttons' => [
                    'temporaryPublish' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-hourglass"></span>', $url, [
                                    'title' => Yii::t('app', 'Temporary Publish Website'),
                                    'data-confirm'=>'Are you sure you want to temporary publish this website?',
                                    'data-method'=>'POST'
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'temporaryPublish') {
                            return Url::toRoute(['temporary-publish','website_id' => $model['website_id']]);
                        }
                    },
                'template' => '{temporaryPublish}',
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