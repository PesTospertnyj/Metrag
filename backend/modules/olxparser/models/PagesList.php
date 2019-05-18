<?php

namespace app\modules\olxparser\models;

use Yii;

/**
 * This is the model class for table "new_parser_olx_pages_list".
 *
 * @property integer $id
 * @property string $page_url
 * @property string $status
 * @property string $time
 * @property string $proxy
 */
class PagesList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'new_parser_olx_pages_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_url'], 'required'],
            [['page_url', 'status'], 'string'],
            [['time'], 'safe'],
            [['proxy'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'page_url' => Yii::t('app', 'Page Url'),
            'status' => Yii::t('app', 'Status'),
            'time' => Yii::t('app', 'Time'),
            'proxy' => Yii::t('app', 'Proxy'),
        ];
    }
}
