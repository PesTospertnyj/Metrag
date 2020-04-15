<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "region".
 *
 * @property integer $region_id
 * @property string $name
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'region_id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    public static function prepareForSelect()
    {
        $items = self::find()->all();
        $arr = [];

        foreach ($items as $item) {
            $arr[$item->region_id] = $item->name;
        }

        return $arr;
    }
}
