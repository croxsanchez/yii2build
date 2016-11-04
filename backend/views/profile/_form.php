<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use yii\jui\DatePicker;
use kartik\date\DatePicker;
use kartik\file\FileInput;

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
  <li><a href="#contact" role="tab" data-toggle="tab">Contact Information</a></li>
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
  <div class="tab-pane vertical-pad" id="contact">
    <?php if (!$model->isNewRecord):?>
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
    
    <?php endif?>
    
  </div>
  <div class="tab-pane vertical-pad" id="photo">
      <?=
        // your fileinput widget for single file upload
        $form->field($model, 'image')->widget(FileInput::classname(), [
            'options'=>['accept'=>'image/*'],
            'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']]
            ])
            ->label('Preview');
    ?>

  </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Save/Upload' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
