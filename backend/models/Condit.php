<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "condit".
 *
 * @property integer $condit_id
 * @property string $name
 */
class Condit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'condit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['display_only_building'], 'integer', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'condit_id' => Yii::t('yii', 'ID'),
            'name' => Yii::t('yii', 'Name'),
            'display_only_building' => 'Отображать на странице здания, только эти пункты',
        ];
    }
}
