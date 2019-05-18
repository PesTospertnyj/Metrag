<?php

namespace backend\models;

use Yii;

class MainSearch extends \yii\base\Model
{
    public $type_realty;
    public $id;
    public $phone;

    public function rules()
    {
        return [
            [['id', 'phone'], 'integer']
        ];
    }
}