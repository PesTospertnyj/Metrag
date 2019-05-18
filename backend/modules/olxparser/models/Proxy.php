<?php

namespace app\modules\olxparser\models;

use Yii;

/**
 * This is the model class for table "new_parser_olx_proxy".
 *
 * @property string $ip
 * @property integer $port
 * @property integer $success
 * @property integer $fail
 */
class Proxy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'new_parser_olx_proxy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip', 'port'], 'required'],
            [['port', 'success', 'fail'], 'integer'],
            //[['ip'], 'string', 'max' => 40],
            [['ip'], 'ip'],
            [['ip'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ip' => Yii::t('app', 'Ip'),
            'port' => Yii::t('app', 'Port'),
            'success' => Yii::t('app', 'Success'),
            'fail' => Yii::t('app', 'Fail'),
        ];
    }

    static public function setProxyStatus($proxy, $success)
    {
        $address = explode(':', $proxy);
        $ip = $address[0];
        $model = Proxy::findOne(['ip' => $ip]);
        if($success)
        {
            $model->updateCounters(['success' => 1]);
        }
        else
        {
            $model->updateCounters(['fail' => 1]);
        }
    }
}
