<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\customer\Website */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="website-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::activeHiddenInput($model, 'customer_id', ['value' => $customer_id]);?>
    
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'payment_method_value')->dropDownList($model->paymentMethodList, 
            ['prompt' => 'Please choose one' ]); ?>

    <?= Html::activeHiddenInput($model, 'payment_status_value', ['value' => 10]);?>
    
    <?= Html::activeHiddenInput($model, 'theme_id', ['value' => 1]);?>
    
    <h3>Domainname choices</h3>
    
    <?= $form->field($domain1, 'name')->textInput(['maxlength' => true])->label('First Choice') ?>

    <?= $form->field($domain1, 'second_name')->textInput(['maxlength' => true])->label('Second Choice') ?>
    


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
