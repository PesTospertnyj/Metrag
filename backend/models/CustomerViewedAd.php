<?php

namespace backend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "customer_viewed_ads".
 *
 */
class CustomerViewedAd extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer_viewed_ads';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'realty_id'], 'required'],
        ];
    }

    public function checkIfAlreadyExists($realty,$type,$customer_id)
    {
        return self::find()->where(['customer_id'=> $customer_id,'realty_id' => $realty,'realty_type_info' =>$type])->exists();
    }
    /**
     * @inheritdoc
     */
}
