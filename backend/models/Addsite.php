<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "addsite".
 *
 * @property integer $id
 * @property string $base
 * @property integer $idbase
 * @property integer $user
 */
class Addsite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'addsite';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['base', 'idbase', 'user'], 'required'],
            [['base'], 'string'],
            [['idbase', 'user'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'base' => Yii::t('app', 'Base'),
            'idbase' => Yii::t('app', 'Idbase'),
            'user' => Yii::t('app', 'User'),
        ];
    }
}
