<?php

use yii\helpers\Html;
use common\models\PermissionHelpers;

/* @var $this yii\web\View */
/* @var $model backend\models\Profile */

$this->title = 'Update Profile: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

$show_this_for_admin = PermissionHelpers::requireMinimumRole('SuperUser');
$show_this_for_seller = PermissionHelpers::requireRole('Seller');
?>
<div class="profile-update">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php if (!Yii::$app->user->isGuest && $show_this_for_seller) {
    ?>
        <?= $this->render('_update_profile', [
            'model' => $model,
            ]) 
        ?>
    <?php
          }
    ?>
        
    <?php if (!Yii::$app->user->isGuest && $show_this_for_admin) {
    ?>
        <?= $this->render('_form', [
            'model' => $model,
            ]) 
        ?>
    <?php
          }
    ?>


</div>
