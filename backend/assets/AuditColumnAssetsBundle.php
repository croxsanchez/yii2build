<?php

namespace backend\assets;

use yii\web\AssetBundle;

class AuditColumnAssetsBundle extends AssetBundle
{
    public $sourcePath = '@backend/assets/audit-column';
    public $css = [
        'styles.css'
    ];
    public $js = [
        'scripts.js'
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
