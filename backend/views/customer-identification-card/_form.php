<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\models\IdentificationCardType;
use backend\models\IdentificationCardInitial;
use backend\models\customer\CustomerType;

/* @var $this yii\web\View */
/* @var $model backend\models\customer\CustomerIdentificationCard */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-identification-card-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'customer_type')->dropDownList($model->customerTypeList, 
            [
                'prompt' => 'Please choose one',
                'onchange' => '
                            $.get(
                            "'.Url::toRoute('dependent-dropdown/card-type').'",
                            { id: $(this).val() } )
                                .done(function( data ) {
                                    $( "#'.Html::getInputId($model, 'card_type').'" ).html( data );
                                }
                            );
                        '
                ]); ?>
    
    <?php
    $document_type = ArrayHelper::map(IdentificationCardType::find()->all(), 'id', 'name');
    echo $form->field($model, 'card_type')->dropDownList(
        $document_type,
        [
            'prompt' => 'Please choose one',
            'onchange' => '
                            $.get(
                            "'.Url::toRoute('dependent-dropdown/initial').'",
                            { id: $(this).val() } )
                                .done(function( data ) {
                                    $( "#'.Html::getInputId($model, 'identification_card_initial_id').'" ).html( data );
                                }
                            );
                        '
        ]
    );
    ?>

    <?php
    $document_initial = ArrayHelper::map(IdentificationCardInitial::find()->all(), 'id', 'initial');
    echo $form->field($model, 'identification_card_initial_id')->dropDownList(
            $document_initial,
        [
            'value' => $model->getIdentificationCardInitialName(),
        ]
    ); ?>

        
    <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
