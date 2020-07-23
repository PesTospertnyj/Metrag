<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "customers_location".
 *
 * @property integer $region_id
 * @property string $name
 */
class CustomerLocation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customers_location';
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'locality_id' => Yii::t('yii', 'Locality'),
            'region_kharkiv_id' => Yii::t('yii', 'Region Kharkiv'),
        ];
    }

    public function rules()
    {
        return [
            [['customer_id','locality_id', 'region_kharkiv_id'], 'safe'],
        ];
    }
}
