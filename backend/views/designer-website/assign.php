<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Designer;
use backend\models\customer\Website;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\DesignerWebsite */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Assign Designer to a Website';
$this->params['breadcrumbs'][] = ['label' => 'Designer Websites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="designer-website-form">
    
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>
    
    <h2>Website's Info:</h2>
    
    <h3><?= Html::encode('Description: ' . $website['description']) ?></h3>
    
    <h3><?= Html::encode('id Nº: ' . $website['id']) ?></h3>
    
    <?= Html::activeHiddenInput($model, 'website_id', ['value' => $website['id']]);?>
    
    <?= $form->field($model, 'designer_id')->dropDownList($model->designerList, ['prompt' => 'Please choose one'])->label('Choose Designer'); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Assign Designer' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
