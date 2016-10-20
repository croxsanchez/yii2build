<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model frontend\models\Profile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-form">

    <?php $form = ActiveForm::begin([
        'options'=>['enctype'=>'multipart/form-data'] // important
    ]); ?>
    
    <?php
        echo $form->field($model, 'filename');
        
        // display the image uploaded or show a placeholder
        // you can also use this code below in your `view.php` file
        $title = isset($model->filename) && !empty($model->filename) ? $model->filename : 'Avatar';
        echo Html::img($model->getImageUrl(), [
            'class'=>'img-thumbnail', 
            'alt'=>$title, 
            'title'=>$title
        ]);
        
        // your fileinput widget for single file upload
        echo $form->field($model, 'image')->widget(FileInput::classname(), [
            'options'=>['accept'=>'image/*'],
            'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']]
            ]);
    ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => 45]) ?>
    
    <br />

    <?php echo $form->field($model, 'birthdate')->widget(DatePicker::className(), 
            ['clientOptions' => ['dateFormat' => 'yy-mm-dd']]); ?>

    <br />

    <?= $form->field($model, 'gender_id')->dropDownList($model->genderList, 
            ['prompt' => 'Please choose one' ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Upload' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
