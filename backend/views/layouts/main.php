<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use common\models\ValueHelpers;
use backend\assets\FontAwesomeAsset;

/**
* @var \yii\web\View $this
* @var string $content
*/

AppAsset::register($this);
FontAwesomeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    $is_admin = ValueHelpers::getRoleValue('Admin');
    $is_seller = ValueHelpers::getRoleValue('Seller');

    if (!Yii::$app->user->isGuest){
        if (!Yii::$app->user->identity->role_id >= $is_seller){
            $title = 'BcauseNet <i class="fa fa-plug"></i> Admin';
        } else {
            $title = 'BcauseNet <i class="fa fa-plug"></i> Your Business';
        }
        NavBar::begin([
            'brandLabel' => $title,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
    } else {
        NavBar::begin([
            'brandLabel' => 'BcauseNet <i class="fa fa-plug"></i>',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
    }

    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id >= $is_seller) {
        $menuItems = [
            ['label' => 'Home', 'url' => ['/site/index']],
        ];
    }


    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id >= $is_admin) {
        $menuItems[] = ['label' => 'Users', 'url' => ['user/index']];
        $menuItems[] = ['label' => 'Profiles', 'url' => ['profile/index']];
        $menuItems[] = ['label' => 'Customers', 'url' => ['customer-records/index']];
        $menuItems[] = ['label' => 'Sellers', 'url' => ['seller/index']];
        $menuItems[] = ['label' => 'Roles', 'url' => ['/role/index']];
        $menuItems[] = ['label' => 'User Types', 'url' => ['/user-type/index']];
        $menuItems[] = ['label' => 'Statuses', 'url' => ['/status/index']];
    } elseif(!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id == $is_seller) {
        $menuItems[] = ['label' => 'Profile', 'url' => ['profile/index']];
        $menuItems[] = [
            'label' => 'Customers',
            'items' => [
                [
                    'label' => 'Create New Customer',
                    'url' => [
                        'customer-records/create',
                        'tag' => 'list'
                    ]
                ],
                [
                    'label' => 'My Customers',
                    'url' => [
                        'customer-records/index',
                        'tag' => 'list'
                    ]
                ],
            ]
        ];
        $menuItems[] = [
            'label' => 'Site Manager',
            'items' => [
                [
                    'label' => 'Sites Pending for Payment',
                    'url' => [
                        'domains/domains-pending-payment',
                        'seller_user_id' => Yii::$app->user->id,
                        'tag' => 'pending'
                    ]
                ],
                [
                    'label' => 'Sites Already Paid',
                    'url' => [
                        'domains/domains-paid-out',
                        'seller_user_id' => Yii::$app->user->id,
                        'tag' => 'paid'
                    ]
                ],
            ]
        ];
        $menuItems[] = [
            'label' => 'My Organization',
            'items' => [
                [
                    'label' => 'Create New Seller',
                    'url' => [
                        'seller/create',
                        'tag' => 'create'
                    ]
                ],
                [
                    'label' => 'Members',
                    'url' => [
                        'seller/index',
                        'tag' => 'list'
                    ]
                ],
                [
                    'label' => 'Statistics',
                    'url' => [
                        'seller/index',
                        'tag' => 'statistics'
                    ]
                ],
            ]
        ];
    }

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = ['label' =>
            'Logout (' . Yii::$app->user->identity->username .')' ,
            'url' => ['/site/logout']];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);

    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; BcauseNet.com <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
