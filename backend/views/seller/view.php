<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermissionHelpers;

/* @var $this yii\web\View */
/* @var $model backend\models\Seller */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sellers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$show_this_for_admin = PermissionHelpers::requireMinimumRole('SuperUser');
$show_this_for_seller = PermissionHelpers::requireRole('Seller');
?>
<div class="seller-view">

    <h1><?= Html::encode('Detail View for Seller ID: ' . $this->title) ?></h1>

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
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'parent_id',
            'total_points',
            'rank_value',
            'rank_date',
            'credits',
        ],
    ]) ?>

</div>
