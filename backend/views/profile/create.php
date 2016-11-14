<?php

use yii\helpers\Html;
use common\models\PermissionHelpers;


/* @var $this yii\web\View */
/* @var $model backend\models\Profile */

$this->title = 'Create Profile for User: ' . $username;
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$show_this_for_admin = PermissionHelpers::requireRole('SuperUser');
$show_this_for_seller = PermissionHelpers::requireRole('Seller');
?>
<div class="profile-create">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php if (!Yii::$app->user->isGuest && ($show_this_for_seller || $show_this_for_admin)) {
    ?>
        <?= $this->render('_form', [
            'model' => $model,
            'seller_id' => $seller_id,
        ]) ?>
    <?php
          }
    ?>

</div>
