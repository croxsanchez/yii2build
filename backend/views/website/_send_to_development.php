<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\customer\Website */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pre-domain-view">
    
    <h3>Customer's Choices for Website's Domain Name</h3>
    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'name',
            'label' => 'Desired Domain Name',
        ],
    ],
]); ?>

</div>

<div class="website-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::activeHiddenInput($model, 'customer_id', ['value' => $customer_id]);?>
    
    <?= $form->field($model, 'description')->textInput(['maxlength' => true])->label('Website\'s Description') ?>
    
    <?= Html::activeHiddenInput($model, 'payment_status_value', ['value' => 20]);?>
    
    <?= Html::activeHiddenInput($model, 'theme_id', ['value' => 1]);?>
    
    <h3>Definitive Website's Domainname</h3>
    
    <?= $form->field($domain, 'name')->textInput(['maxlength' => true])->label('Defnitive Name') ?>

    <h3>Assign Website to Designer</h3>
    
    <?= Html::activeHiddenInput($designer_website, 'website_id', ['value' => $model->id]);?>
    
    <?= $form->field($designer_website, 'designer_id')->dropDownList($designer_website->designerList, ['prompt' => 'Please choose one'])->label('Choose Designer'); ?>
    
    <div class="form-group">
        <?= Html::submitButton('Send to development', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
