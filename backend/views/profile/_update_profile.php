<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use limion\jqueryfileupload\JQueryFileUpload;
//use dosamigos\fileupload\FileUpload;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Profile */
/*$js = <<< 'JS'
var uploadButton = $('<button/>')
    .addClass('btn btn-primary')
    .prop('disabled', true)
    .text('Processing...')
    .on('click', function (e) {
        e.preventDefault();
        var $this = $(this),
            data = $this.data();
        $this
            .off('click')
            .text('Abort')
            .on('click', function () {
                $this.remove();
                data.abort();
            });
        data.submit().always(function () {
            $this.remove();
        });
    }); 
JS;

$this->registerJs($js);*/
?>
<?php
    if ($model->avatar == ""){
        echo \cebe\gravatar\Gravatar::widget([
            'email' => common\models\User::find()->where(['id'=>Yii::$app->user->getId()])->one()->email,
            'options' => [
                'class'=>'profile-image',
                'alt' => common\models\User::find()->where(['id'=>Yii::$app->user->getId()])->one()->username,
                ],
            'size' => 128,
            ]);
    } else {
        $r = str_replace("/web", "", Yii::$app->params['uploadUrl']);
        echo Html::img($r . $model->avatar, ['class' => 'img-thumbnail img-responsive', 'width' => 192]);        
    }
 ?>

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="#general" role="tab" data-toggle="tab">General Settings</a></li>
  <li><a href="#photo" role="tab" data-toggle="tab">Upload Photo</a></li>
</ul>
        
<div class="profile-update">
<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active vertical-pad" id="general">
    
        <?php 
        $form = ActiveForm::begin([
            'options'=>['enctype'=>'multipart/form-data'] 
            ]); // important
        ?>

        <?= $form->field($model, 'first_name')->textInput(['maxlength' => 45]) ?>

        <?= $form->field($model, 'last_name')->textInput(['maxlength' => 45]) ?>

        <br />

        <?php echo $form->field($model, 'birthdate')->widget(DatePicker::className(), 
                ['clientOptions' => ['dateFormat' => 'yy-mm-dd']]); ?>

        <br />

        <?= $form->field($model, 'gender_id')->dropDownList($model->genderList, 
                ['prompt' => 'Please choose one' ]); ?>
  </div>
  <div class="tab-pane vertical-pad" id="photo">
    <?= 
        JQueryFileUpload::widget([
            //'name' => 'files[]',
            'model' => $model,
            'attribute' => 'image',
            'url' => ['/uploads/', 'id' => $model->id], // your route for saving images,
            'appearance'=>'basic', // available values: 'ui','plus' or 'basic'
            'gallery' => true, // whether to use the Bluimp Gallery on the images or not
            'formId' => $form->id,
            'options' => [
                'accept' => 'image/*'
            ],
            'clientOptions' => [
                'maxFileSize' => 2048000,
                'acceptFileTypes'=>new yii\web\JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                'dataType' => 'json',
                'autoUpload'=>false,
                'limitMultiFileUploads' => 1,
                'imageCrop' => true,
                'disableImagePreview' => false,
                'previewThumbnail' => true,
                'previewCrop' => true
            ],
            'clientEvents' => [
                /*'add' => "function (e, data) {
                    data.context = $('<div/>').appendTo('#files');
                    $.each(data.files, function (index, file) {
                        var node = $('<p/>')
                                .append($('<span/>').text(file.name));
                        if (!index) {
                            node
                                .append('<br>')
                                .append(uploadButton.clone(true).data(data));
                        }
                        node.appendTo(data.context);
                    });
                }",
                'processalways' => "function (e, data) {
                    var index = data.index,
                        file = data.files[index],
                        node = $(data.context.children()[index]);
                    if (file.preview) {
                        node
                            .prepend('<br>')
                            .prepend(file.preview);
                    }
                    if (file.error) {
                        node
                            .append('<br>')
                            .append($('<span class=\"text-danger\"/>').text(file.error));
                    }
                    if (index + 1 === data.files.length) {
                        data.context.find('button')
                            .text('Upload')
                            .prop('disabled', !!data.files.error);
                    }
                }",*/
                /*'done'=> "function (e, data) {
                    $.each(data.result.files, function (index, file) {
                        $('<p/>').text(file.name).appendTo('#files');
                    });
                }",*/
                /*'progressall' => "function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                }",*/
                /*'done' => "function (e, data) {
                    $.each(data.result.files, function (index, file) {
                        if (file.url) {
                            var link = $('<a>')
                                .attr('target', '_blank')
                                .attr('data-gallery','')
                                .prop('href', file.url);
                            $(data.context.children()[index])
                                .wrap(link);
                        } else if (file.error) {
                            var error = $('<span class=\"text-danger\"/>').text(file.error);
                            $(data.context.children()[index])
                                .append('<br>')
                                .append(error);
                        }
                    });
                }",*/
                /*'fail' => "function (e, data) {
                    $.each(data.files, function (index) {
                        var error = $('<span class=\"text-danger\"/>').text('File upload failed.');
                        $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                    });
                }"*/
            ],
        ]);
        /*FileUpload::widget([
            'model' => $model,
            'attribute' => 'image',
            'url' => ['/uploads/', 'id' => $model->id],
            'options' => [
                'accept' => 'image/*'
            ],
            'clientOptions' => [
                'maxFileSize' => 2048000,
                'acceptFileTypes'=>new yii\web\JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                'autoUpload'=>false
            ],
            // Also, you can specify jQuery-File-Upload events
            // see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
            'clientEvents' => [
                'fileuploaddone' => 'function(e, data) {
                    jQuery(".fb-image-profile").attr("src",data.result);
                    }',
                'fileuploadprogressall' => "function(e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .bar').css(
                        'width',
                        progress + '%'
                    );
                    }",
                'fileuploadfail' => 'function(e, data) {
                    alert("Image Upload Failed, please try again.");
                    }',
            ],
        ]);*/ 
            
        /*$form->field($model, 'image')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
         'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']],
    ]); */
        /* $form->field($model, 'image')->fileInput(
                 [
                     'class' => 'btn btn-primary',
                     'id' => 'archivos',
                     'extensions' => 'jpg, gif, png'
                     ]) 
         */
                ?>
  </div> <!-- end of upload photo tab -->
</div>
<div class="form-group">
<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
</div>