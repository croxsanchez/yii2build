<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\customer\DomainRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="domain-record-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <?= Html::activeHiddenInput($model, 'customer_id', ['value' => $customer_id]);?>

    <?= $form->field($model, 'domain_choice_value')->dropDownList($model->domainChoiceList, 
            ['prompt' => 'Please choose one' ]); ?>
    
    <?= $form->field($model, 'payment_method_value')->dropDownList($model->paymentMethodList, 
            ['prompt' => 'Please choose one' ]); ?>
    
    <?= $form->field($model, 'payment_status_value')->dropDownList($model->paymentStatusList, 
            ['prompt' => 'Please choose one' ]); ?>
    
    <?= $form->field($model, 'domain_status_value')->dropDownList($model->domainStatusList, 
            ['prompt' => 'Please choose one' ]); ?>
    
    <?= $form->field($model, 'theme_id')->dropDownList($model->themeList, 
            ['prompt' => 'Please choose one' ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
