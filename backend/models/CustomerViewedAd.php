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

    /**
     * @inheritdoc
     */
}