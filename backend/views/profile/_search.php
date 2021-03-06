<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Profile;

/**
* @var yii\web\View $this
* @var backend\models\search\ProfileSearch $model
* @var yii\widgets\ActiveForm $form
*/

?>
<div class="profile-search">
<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>
    
<?= $form->field($model, 'first_name') ?>
    
<?= $form->field($model, 'last_name') ?>
    
<?= $form->field($model, 'birth_date') ?>
    
<?php //echo $form->field($model, 'gender_id')->dropDownList(Profile::getgenderList(),
      //  [ 'prompt' => 'Please Choose One' ]);?>
    
    <?php  echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'filename') ?>

    <?php // echo $form->field($model, 'avatar') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
