<?php

namespace app\modules\parsercd;

use yii\web\AssetBundle;

class ParsercdAssetsBundle extends AssetBundle
{
    // путь к директории, содержимое которой надо опубликовать
    public $sourcePath = '@app/modules/parsercd/assets';

    // путь к JS файлам относительно sourcePath
    public $js = [
        'js/script.js'
    ];
    public $css = [
        'css/style.css'
    ];
    /*public $depends = [
        'OlxAssetsBundle',
    ];

    public $jsOptions = [ 'position' => \yii\web\View::POS_READY ];
*/
    // путь к CSS файлам относительно sourcePath
    /* public $css = [
         'css/some.css'
     ];*/
}