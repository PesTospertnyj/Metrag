<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comfort".
 *
 * @property integer $comfort_id
 * @property string $name
 */
class Comfort extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comfort';
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
            'comfort_id' => Yii::t('app', 'Comfort ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
