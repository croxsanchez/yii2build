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
    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'status_id')->dropDownList($model->statusList,
            [ 'prompt' => 'Please Choose One' ]);?>
    
    <?= $form->field($model, 'role_id')->dropDownList($model->roleList,
            [ 'prompt' => 'Please Choose One' ]);?>
    
    <?= Html::activeHiddenInput($model, 'user_type_id', ['value' => 30]);?>
    
    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>
    
    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
    
    <?php if ($model->isNewRecord): ?>
    
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>
    
    <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => 255]) ?>
    
    <?php endif;?>
    
    <div class="form-group">
    
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>