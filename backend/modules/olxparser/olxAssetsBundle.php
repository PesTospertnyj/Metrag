<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15.04.2017
 * Time: 16:03
 */

namespace app\modules\olxparser;

use yii\web\AssetBundle;

class OlxAssetsBundle extends AssetBundle
{
    // путь к директории, содержимое которой надо опубликовать
    public $sourcePath = '@app/modules/olxparser/assets';

    // путь к JS файлам относительно sourcePath
    public $js = [
        'js/script.js'
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