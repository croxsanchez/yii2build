<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\IdentificationCardInitial;
use backend\models\IdentificationCardType;
use yii\helpers\Url;
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

    <?php
$document_type = ArrayHelper::map(IdentificationCardType::find()->all(), 'id', 'name');
echo $form->field($model, 'ident_card_id')->dropDownList(
    $document_type,
    [
        'prompt' => 'Please choose one',
        'onchange' => '
                        $.get(
                        "'.Url::toRoute('dependent-dropdown/initial').'",
                        { id: $(this).val() } )
                            .done(function( data ) {
                                $( "#'.Html::getInputId($model, 'ident_card_init_id').'" ).html( data );
                            }
                        );
                    '
    ]
);
?>

<?php
echo $form->field($model, 'ident_card_init_id')->dropDownList(
	array(),
    [
        'prompt' => 'Please choose one',
        ['id' => 'initial'],
        'onchange' => '
        				showNumber();
						function showNumber(){
							if (document.getElementById("'.Html::getInputId($model, 'ident_card_init_id').'").selectedIndex > 0)
							{
								document.getElementById("number").style.display="block";
							} else {
								document.getElementById("number").style.display="none";
							}
						}

        			'
    ]
); ?>
<div id="number" style="display:none;">
<?php
    echo $form->field($model, 'number')->textInput(['maxlength' => 255]);
?>
</div>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>
    
    <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => 255]) ?>

    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>

<?php
    ActiveForm::end();
?>

</div>
