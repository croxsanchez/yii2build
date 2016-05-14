<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\bootstrap\Collapse;
use common\models\PermissionHelpers;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-index">
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
if (PermissionHelpers::requireMinimumRole('Admin') && PermissionHelpers::requireStatus('Active')){
?>
<p>
<?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
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
        ['attribute'=>'userIdLink', 'format'=>'raw'],
        ['attribute'=>'userLink', 'format'=>'raw'],
        ['attribute'=>'profileLink', 'format'=>'raw'],
        'email:email',
        'roleName',
        'userTypeName',
        'statusName',
        'created_at',
        ['class' => 'yii\grid\ActionColumn'],
        // 'updated_at',
        ],
    ]); ?>
</div>