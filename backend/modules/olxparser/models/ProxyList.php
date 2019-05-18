<?php

namespace app\modules\olxparser\models;
use Yii;
use app\modules\olxparser\models\Proxy;

class ProxyList extends \yii\base\Model
{
        /**
     * @inheritdoc
     */

    public $list;
    
    public function rules()
    {
        return [
            [['list'], 'required'],
        ];
    }
}

