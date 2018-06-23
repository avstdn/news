<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
//    public $basePath = '@webroot';
//    public $baseUrl = '@web';
    public $sourcePath = '@public/assets';

    public $css = [
        'css/site.css',
        'css/animate.css',
        'css/chartist.css',
    ];

    public $js = [
        'js/script.js',
        'js/chartist.js',
        'js/moment.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        '\rmrevin\yii\fontawesome\AssetBundle'
    ];
}