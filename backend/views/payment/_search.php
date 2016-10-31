<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\PaymentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'amount') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'payment_method_value') ?>

    <?= $form->field($model, 'invoice_id') ?>

    <?php // echo $form->field($model, 'domain_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
