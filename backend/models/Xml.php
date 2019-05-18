<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "xml".
 *
 * @property integer $id
 * @property string $type
 * @property integer $type_id
 * @property integer $besplatka
 * @property integer $est
 * @property integer $mesto
 */
class Xml extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'xml';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'type_id', 'besplatka', 'est', 'mesto'], 'required'],
            [['type_id', 'besplatka', 'est', 'mesto'], 'integer'],
            [['type'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'type_id' => Yii::t('app', 'Type ID'),
            'besplatka' => Yii::t('app', 'Besplatka'),
            'est' => Yii::t('app', 'Est'),
            'mesto' => Yii::t('app', 'Mesto'),
        ];
    }



}
