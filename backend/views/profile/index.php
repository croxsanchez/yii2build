<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\bootstrap\Collapse;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Profiles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index">

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
    ]); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            ['attribute'=>'profileIdLink', 'format'=>'raw'],
            ['attribute'=>'userLink', 'format'=>'raw'],
            //'user_id',
            'seller_id',
            'first_name:ntext',
            'last_name',
            'birth_date',
            //'genderName',
            // 'gender_id',
            // 'created_at',
            // 'updated_at',
            // 'filename',
            // 'avatar',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
