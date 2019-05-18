<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "expert_child".
 *
 * @property integer $id
 * @property integer $expert_id
 * @property integer $child_id
 */
class ExpertChild extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'expert_child';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['expert_id', 'child_id'], 'required'],
            [['expert_id', 'child_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'expert_id' => Yii::t('app', 'ID'),
            'child_id' => Yii::t('app', 'Child ID'),
        ];
    }

    public function create($expert_id, $child_id)
    {
        $this->expert_id = $expert_id;
        $this->child_id = $child_id;
        $this->save();
    }

    public static function getExpert($child_id)
    {
        $expert = ExpertChild::find()->where(['child_id' => $child_id])->one();
        return $expert;
    }

    public function getExpertId($child_id)
    {
        $expert = ExpertChild::find()->where(['child_id' => $child_id])->one();
        return $expert->id;
    }


}
