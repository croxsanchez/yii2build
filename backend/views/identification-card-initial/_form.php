<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\customer\IdentificationCardInitialRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="identification-card-initial-record-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'value')->textInput() ?>

    <?= $form->field($model, 'initial')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'identification_card_type_value')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
