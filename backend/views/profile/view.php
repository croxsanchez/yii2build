<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermissionHelpers;

/* @var $this yii\web\View */
/* @var $model backend\models\Profile */

$this->title = $model->first_name . ' ' . $model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$show_this_for_admin = PermissionHelpers::requireRole('Superuser');
$show_this_for_seller = PermissionHelpers::requireRole('Seller');
?>
<div class="profile-view">

    <h1><?= Html::encode( 'Profile: ' . $this->title) ?></h1>

    <p>
        <?php if (!Yii::$app->user->isGuest && ($show_this_for_admin || $show_this_for_seller)) {
                    echo Html::a('Update', ['update', 'id' => $model->id],
                            [
                                'class' => 'btn btn-primary'
                            ]);
            }?>

        <?php if (!Yii::$app->user->isGuest && $show_this_for_admin) {
                    echo Html::a('Delete', ['delete', 'id' => $model->id],
                            [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ]);
                }?>
    </p>
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
    <?php
    if (!Yii::$app->user->isGuest && $show_this_for_admin) {
        echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                ['attribute'=>'userLink', 'format'=>'raw'],
                'id',
                'seller_id',
                'first_name:ntext',
                'last_name',
                'email',
                'birth_date',
                //'gender.gender_name',
                'created_at',
                'updated_at',
                //'filename',
                //'avatar',
            ],
        ]);
    } elseif ($show_this_for_seller) {
        echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                'username',
                'first_name:ntext',
                'last_name',
                'email',
                'birth_date',
                //'gender.gender_name',
                'created_at',
                'updated_at',
                //'filename',
                //'avatar',
            ],
        ]);
    }
     ?>
    <?php if (!Yii::$app->user->isGuest && ($show_this_for_admin || $show_this_for_seller)): ?>
    <!-- subtables will be here... -->
    <h2>Phones</h2>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query' => $model->getSellerPhones(),
            'pagination' => false
        ]),
        'columns' => [
            'purpose',
            'number',
        ]
    ]);?>
    
    <h2>Addresses</h2>
    <?php
        $dataProvider->sort->attribute['street']  = [
                        'asc' => ['street' => SORT_ASC],
                        'desc' => ['street' => SORT_DESC]
                    ];
    ?>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider(
                [
                    'query' => $model->getSellerAddresses(), 
                    'pagination' => false
                ]
        ),
        'columns' => [
            'purpose',
            'country',
            'state',
            'city',
            [
                'attribute' => 'street',
                'label' => 'Address',
                'value' => function ($model) {
                    return implode(', ',
                        array_filter(
                            $model->getAttributes(
                                ['street', 'building', 'apartment'])));
                }
            ],
        ],
    ]);?>
    
    <?php endif;?>

</div>
