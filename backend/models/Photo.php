<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "photo".
 *
 * @property integer $photo_id
 * @property integer $type_realty_id
 * @property integer $object_id
 * @property string $path
 */
class Photo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_realty_id', 'object_id', 'path'], 'required'],
            [['type_realty_id', 'object_id'], 'integer'],
            [['path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'photo_id' => Yii::t('app', 'ID'),
            'type_realty_id' => Yii::t('app', 'Type Realty ID'),
            'object_id' => Yii::t('app', 'Object ID'),
            'path' => Yii::t('app', 'Path'),
        ];
    }
}
