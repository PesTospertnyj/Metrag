<?php
namespace app\modules\olxparser\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ParserSearch extends Parser
{

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        //$query = Parser::find()->orderBy('id DESC');
        $query = Parser::find()->where(['enabled' => '10']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }
}
