<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\customer\DomainChoiceRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="domain-choice-record-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'value')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
