<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermissionHelpers;

/* @var $this yii\web\View */
/* @var $model backend\models\Profile */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$show_this_for_admin = PermissionHelpers::requireMinimumRole('SuperUser');
$show_this_for_seller = PermissionHelpers::requireRole('Seller');
?>
<div class="profile-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (!Yii::$app->user->isGuest && ($show_this_for_admin || $show_this_for_seller)) {
                    echo Html::a('Update', ['update', 'id' => $model->id],
                            [
                                'class' => 'btn btn-primary'
                            ]);
            }?>
        
        <?php if (!Yii::$app->user->isGuest && $show_this_for_admin) {
                    echo Html::a('Delete', ['delete', 'id' => $model->id], 
                            [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ]);
                }?>
    </p>
<?php
    if ($model->avatar == ""){
        echo \cebe\gravatar\Gravatar::widget([
            'email' => common\models\User::find()->where(['id'=>Yii::$app->user->getId()])->one()->email,
            'options' => [
                'class'=>'profile-image',
                'alt' => common\models\User::find()->where(['id'=>Yii::$app->user->getId()])->one()->username,
                ],
            'size' => 128,
            ]);
    } else {
        $r = str_replace("/web", "", Yii::$app->params['uploadUrl']);
        echo Html::img($r . $model->avatar, ['class' => 'img-thumbnail img-responsive', 'width' => 192]);        
    }
 ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attribute'=>'userLink', 'format'=>'raw'],
            'id',
            'first_name:ntext',
            'last_name',
            'birthdate',
            'gender.gender_name',
            'created_at',
            'updated_at',
            'filename',
            'avatar',
        ],
    ]) ?>

</div>
