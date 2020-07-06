<?php
return [
	'language' => 'ru-RU',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                
            ],
        ],
        'i18n' => [
        'translations' => [
            'app*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@yii/messages',
                'sourceLanguage' => 'en-US',
                'fileMap' => [
                    'app'       => 'app.php',
                    'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'jwt' => [
            'class' => '\sizeg\jwt\Jwt',
            'key' => 'secret',
            // You have to configure ValidationData informing all claims you want to validate the token.
            'jwtValidationData' => '\api\components\JwtValidationData',
        ],
    ],
    'modules' => [
            'yii2images' => [
            'class' => 'rico\yii2images\Module',
            //be sure, that permissions ok 
            //if you cant avoid permission errors you have to create "images" folder in web root manually and set 777 permissions
            'imagesStorePath' => 'upload/store', //path to origin images
            //'imagesStorePath' => '/backend/web/upload/store', //path to origin images
            //'imagesUploadPath' => '/advanced/frontend/web/upload/store', //path to origin images
            'imagesCachePath' => 'upload/cache', //path to resized copies
            'graphicsLibrary' => 'Imagick', //but GD really its better to use 'Imagick' 
            //'placeHolderPath' => '@webroot/images/placeHolder.png', // if you want to get placeholder when image not exists, string will be processed by Yii::getAlias
        ],

        'olxparser' => [
            'class' => 'app\modules\olxparser\Module',
        ],
//        'api' => [
//            'class' => 'app\modules\api\Module',
//        ],

        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['*']
        ],

    ],
    
        
    

];
