<?php

namespace backend\models;

use Yii;
use backend\models\NewSiteSubType;
use backend\models\NewSiteState;
use backend\models\NewSiteStatus;
use backend\models\Agents;
use common\models\LivedComplex;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "news".
 *
 */
class ModelData
{
    public static function getData()
    {
        return [
            'sub_types' => array_merge([0 => ''],ArrayHelper::map(NewSiteSubType::find()->asArray()->all(), 'id', 'name')),
            'states' => array_merge([0 => ''],ArrayHelper::map(NewSiteSubType::find()->asArray()->all(), 'id', 'name')),
            'statuses' => array_merge([0 => ''], ArrayHelper::map(NewSiteStatus::find()->orderBy(['id' => 'ASC'])->asArray()->all(), 'id', 'name')),
            'bathroom_types' => [
                1 => 'Совмещенный',
                2 => 'Разделенный',
            ],
            'deal_type' => [
                2 => 'Продажа',
                1 => 'Аренда',
            ],
            'lived_complex' => LivedComplex::find()->select(['name', 'id'])->orderby('name')->indexBy('id')->column(),
            'agents' => ArrayHelper::map(Agents::find()->asArray()->all(), 'id', 'name'),

        ];
    }
    public static function getCurrentAgentOnUserId($userId)
    {
        return Agents::find()->where(['user_id' => $userId])->asArray()->one();
    }
    public static function getCurrentAgentId()
    {

        return Agents::find()->select('id')->where(['user_id' => $_SESSION['__id']])->asArray()->one()['id'];
    }

    public static function hasMaxAgents($model)
    {
        return $model->agent1_id && $model->agent2_id && $model->agent3_id;
    }

}
