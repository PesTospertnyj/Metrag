<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "region_kharkiv_admin".
 *
 * @property integer $region_kharkiv_admin_id
 * @property string $name
 */
class RegionKharkivAdmin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region_kharkiv_admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'region_kharkiv_admin_id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
