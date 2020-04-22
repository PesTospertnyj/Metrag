<?php

namespace api\components;

use Yii;
use yii\helpers\Url;

class JwtValidationData extends \sizeg\jwt\JwtValidationData
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        $url = Url::base('https');

        $this->validationData->setIssuer($url);
        $this->validationData->setAudience($url);
        $this->validationData->setId(
            '4f1g23a12aa'
        );

        parent::init();
    }
}