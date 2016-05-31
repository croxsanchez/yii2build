<?php

namespace backend\assets;

use yii\web\AssetBundle;

class ApplicationUiAssetBundle extends AssetBundle
{
    public $sourcePath = '@backend/assets/ui';
    public $css = [
        'css/main.css'
    ];
    public $js = [
        'js/main.js'
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\web\YiiAsset',
        'backend\assets\AuditColumnAssetsBundle'
    ];
}
