<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $title
 * @property string $image
 * @property string $text
 * @property string $date
 */
class NewSiteSubType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'new_site_subtype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
            [['type_id'], 'integer'],
        ];
    }

//    /**
//     * @inheritdoc
//     */
//    public function attributeLabels()
//    {
//        return [
//            'id' => Yii::t('app', 'ID'),
//            'title' => Yii::t('app', 'Title'),
//            'image' => Yii::t('app', 'Image'),
//            'text' => Yii::t('app', 'Text'),
//            'date' => Yii::t('app', 'Date'),
//        ];
//    }
}
