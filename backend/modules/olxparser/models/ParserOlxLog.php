<?php

namespace app\modules\olxparser\models;

use Yii;

/**
 * This is the model class for table "new_parser_olx_log".
 *
 * @property integer $id
 * @property string $text
 * @property string $time
 */
class ParserOlxLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'new_parser_olx_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text'], 'string'],
            [['time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'text' => Yii::t('app', 'Text'),
            'time' => Yii::t('app', 'Time'),
        ];
    }
}
