<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermissionHelpers;

/* @var $this yii\web\View */
/* @var $model backend\models\customer\CustomerRecord */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Customer Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$show_this_for_admin = PermissionHelpers::requireMinimumRole('SuperUser');
$show_this_for_seller = PermissionHelpers::requireRole('Seller');
?>
<div class="customer-record-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?php if (!Yii::$app->user->isGuest && $show_this_for_admin): 
        ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('View Customers', ['index'], ['class' => 'btn btn-primary']) ?>
    <?php elseif (!Yii::$app->user->isGuest && $show_this_for_seller): ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('My Customers', ['index'], ['class' => 'btn btn-primary']) ?>
    <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'birth_date',
            'notes:ntext',
            'customer_type_id',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'id_card_number',
        ],
    ]) ?>

</div>
