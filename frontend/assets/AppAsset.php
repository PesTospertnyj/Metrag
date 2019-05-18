<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/custom.css',
        'css/main.css',
        'css/site.css',
        //'css/adstracker.css',
        'css/css_2.css',
        //'css/jquery.fs.selecter.css',
        
        'css/radios-to-slider.css',
        'css/slider.css',
        ];
    public $js = [
        'js/jquery.flexslider-min.js',
        'js/jquery.fs.selecter.min.js',
        'js/jquery.radios-to-slider.js',
        //'js/script.js',
        'js/script-view.js',
        'js/tabs.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
