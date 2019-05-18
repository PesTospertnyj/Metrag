<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "type_realty".
 *
 * @property integer $type_realty_id
 * @property string $name
 * @property string $name_table
 */
class TypeRealty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'type_realty';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'name_table'], 'required'],
            [['name', 'name_table'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'type_realty_id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'name_table' => Yii::t('app', 'Name Table'),
        ];
    }
}
