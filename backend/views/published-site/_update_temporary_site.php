<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\customer\TemporarySite */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="temporary-site-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url_status')->checkbox()->label('Activate') ?>
    
    <?= Html::activeHiddenInput($model, 'website_id', ['value' => $website_id]);?>
    
    <?= Html::activeHiddenInput($model, 'designer_id', ['value' => $designer_id]);?>
    
    <?= Html::activeHiddenInput($model, 'seller_id', ['value' => $seller_id]);?>
    
    <?= Html::activeHiddenInput($model, 'customer_id', ['value' => $customer_id]);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
