<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "xml_data".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 */
class XmlData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'xml_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
            //[['name', 'value'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    public static function getTimestamp(){
        $timestamp = null;
        $time = self::findOne(['name' => 'timestamp']);
        if ($time->value){
            $timestamp = date('Y-m-d H:i:s', $time['value']);
        }
        return $timestamp;
    }
}
