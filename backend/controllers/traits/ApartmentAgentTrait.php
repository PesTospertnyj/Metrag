<?php


namespace backend\controllers\traits;

use backend\models\Apartment;
use common\models\Area;
use common\models\Building;
use common\models\Commercial;
use common\models\House;

trait ApartmentAgentTrait
{
    /**
     * @param $agentId
     * @param Apartment|Building|House|Area|Commercial $model
     * @return bool
     */
    protected function addAgentIdToModel($agentId, $model)
    {
        if (!$model->agent1_id) {
            $model->agent1_id = $agentId;
        } elseif (!$model->agent2_id) {
            $model->agent2_id = $agentId;
        } elseif (!$model->agent3_id) {
            $model->agent3_id = $agentId;
        } else {
            return false;
        }

        return true;
    }

    protected function isAgentAttachedToModel($agentId, $model)
    {
        return in_array($agentId, [
            $model->agent1_id,
            $model->agent2_id,
            $model->agent3_id,
        ]);
    }

    protected function hasAtLeastOneAgent($model)
    {
        return $model->agent1_id !== "" || $model->agent2_id !== "" || $model->agent3_id !== "";
    }
}
