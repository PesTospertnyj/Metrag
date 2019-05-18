<?php

namespace common\models;

use Yii;
use backend\models\Image;
use backend\models\TypeObject;
use backend\models\RegionKharkiv;
use backend\models\Street;
use backend\models\Course;
use backend\models\Locality;
use backend\models\Region;


class LivedComplex extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lived_complex';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            //[['description'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

}
