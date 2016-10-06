<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;


/* Create Seller UI
 * @var $this yii\web\View
 * @var $model backend\models\Seller
 * @var $user common\models\User
 */

$this->title = 'Create Seller';
$this->params['breadcrumbs'][] = ['label' => 'Sellers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="seller-create">

    <h1><?= Html::encode($this->title) ?></h1>

<?php
$form = ActiveForm::begin([
'id' => 'add-seller-form',
]);
?>
<?= $form->errorSummary($model); ?>
    
    <?= Html::activeHiddenInput($model, 'status_id', ['value' => 10]);?>
    
    <?= Html::activeHiddenInput($model, 'role_id', ['value' => 20]);?>
    
    <?= Html::activeHiddenInput($model, 'user_type_id', ['value' => 30]);?>
    
    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>
    
    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>

    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>
    
<?php
    ActiveForm::end();
?>

</div>
