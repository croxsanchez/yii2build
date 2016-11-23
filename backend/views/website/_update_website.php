<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\customer\Website */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="website-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'online_store')->checkbox() ?>

    <?= $form->field($model, 'social_media')->checkbox() ?>
    
    <?= $form->field($model, 'payment_method_value')->dropDownList($model->paymentMethodList, 
            ['prompt' => 'Please choose one' ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
