<?php
use backend\models\Agents;
?>
<style>
    .agents_list {
        border: 1px solid #e8e8e8;
        padding: 22px;
    }
    .agents_list .form-group {
        margin-bottom: 0;
    }
    .agents_list label {
        margin-bottom: 0;
    }
    .agent_join {
        font-weight: 700;
        font-size: 15px;
        letter-spacing: 0.4px;
        background: #b84545;
        width: 157px;
        padding: 6px 14px;
        color: #fffffffa;
        border-radius: 6px;
        margin-top: 16px;
        border: 1px solid #ddcfcf;
        cursor: pointer;
        width: 100%;
        text-align: center;
    }

    .agents_list_one {
        margin: 7px 0px;
    }
</style>
<?php
$agent = Agents::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
if($agent && empty($model->agent1_id)) {
   $model->agent1_id = $agent->id;
}
?>
<div class="agents_list">
    <div><b>Список агентов:</b></div>
    <?php if(Yii::$app->user->id === 1 || current(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))->name === 'expert') { ?>
        <?= $form->field($model,'agent1_id')->dropDownList($data['agents'], ['prompt'=>'', 'value' => $agentId])->label(''); ?>
        <?= $form->field($model,'agent2_id')->dropDownList($data['agents'], ['prompt'=>''])->label(''); ?>
        <?= $form->field($model,'agent3_id')->dropDownList($data['agents'], ['prompt'=>''])->label(''); ?>
    <?php } else { ?>
        <div class="agents_list_one"><?= $data['agents'][$model->agent1_id] ?></div>
        <div class="agents_list_one"><?= $data['agents'][$model->agent2_id] ?></div>
        <div class="agents_list_one"><?= $data['agents'][$model->agent3_id] ?></div>
        <div class="agent_join"><?= $hasMaxAgents ? 'Все агенты выбранны': 'Присоединиться' ?></div>
    <?php } ?>
</div>