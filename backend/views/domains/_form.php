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

    <?= $form->field($model, 'customer_id')->textInput() ?>

    <?= $form->field($model, 'domain_choice_value')->textInput() ?>

    <?= $form->field($model, 'payment_status_value')->textInput() ?>

    <?= $form->field($model, 'domain_status_value')->textInput() ?>

    <?= $form->field($model, 'theme_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
