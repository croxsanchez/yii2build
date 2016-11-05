<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use yii\jui\DatePicker;
use kartik\date\DatePicker;
//use kartik\file\FileInput;
use limion\jqueryfileupload\JQueryFileUpload;

/* @var $this yii\web\View */
/* @var $model frontend\models\Profile */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
    if (!isset($model->avatar)){
        echo \cebe\gravatar\Gravatar::widget([
            'email' => common\models\User::find()->where(['id'=>Yii::$app->user->getId()])->one()->email,
            'options' => [
                'class'=>'profile-image',
                'alt' => common\models\User::find()->where(['id'=>Yii::$app->user->getId()])->one()->username,
                ],
            'size' => 128,
            ]);
    } else {
        
        $title = isset($model->filename) && !empty($model->filename) ? $model->filename : 'Avatar';
        $r = str_replace("/web", "", Yii::$app->params['uploadUrl']);
        // display the image uploaded or show a placeholder
        // you can also use this code below in your `view.php` file
        echo Html::img($r . $model->avatar, 
                [
                    'class' => 'img-thumbnail img-responsive', 
                    'width' => 192,
                    'alt'=>$title, 
                    'title'=>$title
                ]);
    }
 ?>

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="#personal" role="tab" data-toggle="tab">Personal Details</a></li>
<?php if (!$model->isNewRecord):?>  <li><a href="#contact" role="tab" data-toggle="tab">Contact Information</a></li> <?php endif; ?>
  <li><a href="#photo" role="tab" data-toggle="tab">Upload Photo</a></li>
</ul>
        
<div class="profile-update">
<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active vertical-pad" id="personal">

    <?php $form = ActiveForm::begin([
        'options'=>['enctype'=>'multipart/form-data'] // important
    ]); ?>
    
    <?= $form->field($model, 'first_name')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => 45]) ?>
    
    <?= $form->field($model, 'birth_date')->widget(DatePicker::className(),
                [
                    'name' => 'birth_date', 
                    'value' => date('Y-m-d'),
                    'options' => ['placeholder' => 'Birth date format yyyy-mm-dd...'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ]
                ]);    ?>
  </div>
 <?php if (!$model->isNewRecord):?>
  <div class="tab-pane vertical-pad" id="contact">
    <!-- subtables will be here... -->
    <h2>Phones</h2>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query' => $model->getSellerPhones(),
            'pagination' => false
        ]),
        'columns' => [
            //'id',
            'number',
            'purpose',
            [
                'class' => \yii\grid\ActionColumn::className(),
                'controller' => 'seller-phone',
                'header' => Html::a(
                        '<i class="glyphicon glyphicon-plus"></i>&nbsp;Add New', 
                        ['seller-phone/create', 'relation_id' => $model->id]
                ),
                'template' => '{update}{delete}',
            ]
        ]
    ]);?>
    
    <h2>Addresses</h2>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider(
                [
                    'query' => $model->getSellerAddresses(), 
                    'pagination' => false
                ]
        ),
        'columns' => [
            //'id',
            [
                'label' => 'Address',
                'value' => function ($model) {
                    return implode(', ',
                        array_filter(
                            $model->getAttributes(
                                ['country', 'state', 'city', 'street',
                                    'building', 'apartment'])));
                }
            ],
            'purpose',
            [
                'class' => \yii\grid\ActionColumn::className(),
                'controller' => 'seller-address',
                'template' => '{update}{delete}',
                'header' => Html::a(
                        '<i class="glyphicon glyphicon-plus"></i>&nbsp;Add New',
                        ['seller-address/create', 'relation_id' => $model->id]
                ),
            ],
        ],
    ]);?>
  </div>
 <?php endif?>
  <div class="tab-pane vertical-pad" id="photo">
      <?= /*
        // your fileinput widget for single file upload
        $form->field($model, 'image')->widget(FileInput::classname(), [
            'options'=>['accept'=>'image/*'],
            'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']]
            ])
            ->label('Preview');
       *
       */
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
                'add' => "function (e, data) {
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
                /*'processalways' => "function (e, data) {
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
  </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Save/Upload' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
