<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var common\models\User $model
* @var yii\widgets\ActiveForm $form
*/

?>
<div class="user-form">
    <?= $model->status_id;?>
    
    <?= $model->role_id;?>
    
    <?= $model->user_type_id;?>
    
    <?= $model->username; ?>
    
    <?= $model->email; ?>
        
    <?= $model->password_hash; ?>
    
    <?= $model->auth_key; ?>
    
</div>