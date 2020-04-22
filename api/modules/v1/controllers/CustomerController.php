<?php

namespace api\modules\v1\controllers;

use backend\models\Customer;
use app\models\CustomerSearch;
use Yii;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class CustomerController extends Controller
{
    /**
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->asJson([
            'items' => $dataProvider->query->all(),
            'status' => 200,
        ]);
    }

    /**
     * @return \yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            Yii::$app->response->statusCode = 201;

            return $this->asJson([
                'item' => $model,
                'status' => 201,
            ]);
        } else {
            Yii::$app->response->statusCode = 500;

            return $this->asJson([
                'errors' => $model->getErrors(),
                'status' => 500,
            ]);
        }
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            return $this->asJson([
                'item' => $model,
                'status' => 200,
            ]);
        } else {
            Yii::$app->response->statusCode = 500;

            return $this->asJson([
                'errors' => $model->getErrors(),
                'status' => 500,
            ]);
        }
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->asJson(['status' => 200]);
    }

    /**
     * @param $id
     * @return Customer
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
