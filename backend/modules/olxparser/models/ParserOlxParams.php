<?php

namespace app\modules\olxparser\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "new_parser_olx_params".
 *
 * @property integer $id
 * @property integer $pack
 * @property string $name
 * @property string $label
 * @property string $value
 * @property string $default_value
 * @property string $textfield
 */
class ParserOlxParams extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'new_parser_olx_params';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pack', 'name', 'label', 'value', 'default_value'], 'required'],
            [['pack'], 'integer'],
            [['value', 'default_value'], 'string'],
            ['textfield', 'default', 'value' => 0],
            [['name', 'label'], 'string', 'max' => 255],
        ];
    }

    public static function params()
    {
        $array = self::find()->select('name, value')->where(['pack' => 1])->all();

        $res = [];
        foreach($array as $param) {
            // stripslashes($param->value)
            // str_replace("\\\\", "\\", $param->value)
            $res[$param->name] = $param->value;
        }

        $list_users_agents = [];
        foreach (explode(PHP_EOL, $res['list_users_agents']) as $ua) {
            $list_users_agents[] = trim($ua);
        }
        $res['list_users_agents'] = $list_users_agents;

        $list_proxy = [];
        foreach (explode(PHP_EOL, $res['list_proxy']) as $proxy) {
            $list_proxy[] = trim($proxy);
        }
        $res['list_proxy'] = $list_proxy;

        // ===

        $regs = require(__DIR__ . "/../constants.php");

        return $res + $regs;
    }
}
