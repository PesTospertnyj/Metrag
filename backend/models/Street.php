<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "street".
 *
 * @property integer $street_id
 * @property string $name
 * @property string $name_google
 */
class Street extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'street';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'name_google'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'street_id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'name_google' => 'Имя в GoogleMaps',
        ];
    }
}
