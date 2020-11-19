<?php

namespace backend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "customer_viewed_ads".
 *
 */
class CustomerPhones extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer_phones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'phone'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
}
