<?php

use Yii;
use yii\helpers\Html;
use yii\grid\GridView;
use \yii\bootstrap\Collapse;
use common\models\PermissionHelpers;
use yii\data\ActiveDataProvider;
use yii\db\mysql\QueryBuilder;
use yii\db\Query;
use backend\models\Seller;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\SellerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$condition = 'seller.parent_id = '.  Yii::$app->user->id;

$query = (new Query())
        ->select(['user.id AS userIdLink', 'user.username AS userLink', '(SELECT username FROM user where seller.parent_id = user.id) AS parentUserLink'])
        ->from('user')
        ->leftJoin('seller', 'seller.user_id = user.id')
        ->where($condition);
    

//  Crear un comando. Se puede obtener la consulta SQL actual utilizando $command->sql
$command = $query->createCommand();

// Ejecutar el comando:
$rows = $command->queryAll();

$provider = new ActiveDataProvider([
    'query' => $query,
    'pagination' => [
        'pageSize' => 3,
    ],
    'sort' => [
        'attributes' => ['userIdLink','userLink', 'parentUserLink'],
    ],
]);

$this->title = 'Mi organización';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="seller-index">

    <h1><?= Html::encode($this->title).'. Vendedor: '.Html::encode(Yii::$app->user->identity->username); ?></h1>
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
        'dataProvider' => $provider,
        'filterModel' => $searchModel,
        'columns' => [
            // 'id',
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute'=>'userIdLink', 'format'=>'raw'],
            ['attribute'=>'userLink', 'format'=>'raw'],
            ['attribute'=>'parentUserLink', 'format'=>'raw'],

            //'username',
            //'parentUsername',
            //'user',
            //'parent',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
