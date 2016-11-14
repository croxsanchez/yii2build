<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\customer\WebsiteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="website-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'customer_id') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'theme_id') ?>

    <?= $form->field($model, 'payment_method_value') ?> 
 
    <?php // echo $form->field($model, 'created_at') ?> 

    <?php // echo $form->field($model, 'created_by') ?> 

    <?php // echo $form->field($model, 'updated_at') ?> 

    <?php // echo $form->field($model, 'updated_by') ?> 

    <?php // echo $form->field($model, 'payment_status_value') ?> 

    <?php // echo $form->field($model, 'domain_id') ?> 
 
   <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
