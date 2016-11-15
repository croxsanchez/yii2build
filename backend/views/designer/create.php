<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\Designer */

$this->title = 'Create Designer';
$this->params['breadcrumbs'][] = ['label' => 'Designers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="designer-create">

    <h1><?= Html::encode($this->title) ?></h1>

   <?php
    $form = ActiveForm::begin([
    'id' => 'add-seller-form',
    ]);
    ?>
    <?= $form->errorSummary($model); ?>

    <?= Html::activeHiddenInput($model, 'status_id', ['value' => 10]);?>

    <?= Html::activeHiddenInput($model, 'role_id', ['value' => 10]);?>

    <?= Html::activeHiddenInput($model, 'user_type_id', ['value' => 30]);?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'id_card_number')->textInput(['maxlength' => 40]); ?>
    
    <?= $form->field($model, 'first_name')->textInput(['maxlength' => 45]); ?>
    
    <?= $form->field($model, 'last_name')->textInput(['maxlength' => 45]); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>
    
    <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => 255]) ?>

    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>

<?php
    ActiveForm::end();
?>

</div>
