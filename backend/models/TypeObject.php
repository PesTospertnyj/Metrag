<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "type_object".
 *
 * @property integer $type_object_id
 * @property integer $type_realty_id
 * @property string $name
 */
class TypeObject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'type_object';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_realty_id', 'name'], 'required'],
            [['type_realty_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'type_object_id' => Yii::t('app', 'ID'),
            'type_realty_id' => Yii::t('app', 'Type Realty ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    public function getTypeObject()
    {
        return TypeObject::findOne($this->type_object_id);
    }
}
