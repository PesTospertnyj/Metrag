<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "metro".
 *
 * @property integer $id
 * @property string $name
 */
class Agents extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agents';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['numbers'], 'string'],
            [['description'], 'string'],
            [['user_id'], 'unique'],
            [['is_publish'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => 'Имя',
            'numbers' => 'Номера',
            'description' => Yii::t('app', 'Description'),
            'user' => 'Имя пользователя',
            'is_publish' => 'Опубликовать на новом сайте'
        ];
    }
}
