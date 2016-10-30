<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Seller */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seller-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'parent_id')->textInput() ?>

    <?= $form->field($model, 'total_points')->textInput() ?>

    <?= $form->field($model, 'rank_value')->textInput() ?>

    <?= $form->field($model, 'rank_date')->textInput() ?>

    <?= $form->field($model, 'credits')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
