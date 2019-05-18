<?php

namespace backend\controllers;

use app\modules\parsercd\models\Parsercd;
use Yii;

use common\models\Apartment;
use common\models\Area;
use common\models\Building;
use common\models\House;
use common\models\Commercial;
use common\models\Rent;

use backend\models\AgentsSearch;
use backend\models\Agents;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use backend\models\ApartmentFind;

use backend\models\ModelData;
use backend\models\User;
use backend\models\UserSearch;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * ApartmentController implements the CRUD actions for Apartment model.
 */
class AgentsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => Yii::$app->getModule('users')->adminRoles
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Apartment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AgentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'users' => ArrayHelper::map(Agents::find()->asArray()->all(), 'id', 'name'),
        ]);
    }


    /**
     * Displays a single Course model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->redirect('/admin/agents');
    }

    /**
     * Creates a new Course model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //var_dump(ArrayHelper::map(Agents::find()->asArray()->all(), 'id', 'name')); exit;
        $model = new Agents();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'users' => ArrayHelper::map(User::find()->asArray()->all(), 'id', 'username'),
            ]);
        }
    }

    /**
     * Updates an existing Course model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->numbers = implode(',', Yii::$app->request->post('numbers_list'));
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'users' => ArrayHelper::map(User::find()->asArray()->all(), 'id', 'username'),
            ]);
        }
    }

    /**
     * Deletes an existing Course model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete()) {
            Apartment::updateAll(['agent1_id' => null], ['agent1_id' => $id]);
            Apartment::updateAll(['agent2_id' => null], ['agent2_id' => $id]);
            Apartment::updateAll(['agent3_id' => null], ['agent3_id' => $id]);

            Area::updateAll(['agent1_id' => null], ['agent1_id' => $id]);
            Area::updateAll(['agent2_id' => null], ['agent2_id' => $id]);
            Area::updateAll(['agent3_id' => null], ['agent3_id' => $id]);

            Building::updateAll(['agent1_id' => null], ['agent1_id' => $id]);
            Building::updateAll(['agent2_id' => null], ['agent2_id' => $id]);
            Building::updateAll(['agent3_id' => null], ['agent3_id' => $id]);

            House::updateAll(['agent1_id' => null], ['agent1_id' => $id]);
            House::updateAll(['agent2_id' => null], ['agent2_id' => $id]);
            House::updateAll(['agent3_id' => null], ['agent3_id' => $id]);

            Commercial::updateAll(['agent1_id' => null], ['agent1_id' => $id]);
            Commercial::updateAll(['agent2_id' => null], ['agent2_id' => $id]);
            Commercial::updateAll(['agent3_id' => null], ['agent3_id' => $id]);

            Rent::updateAll(['agent1_id' => null], ['agent1_id' => $id]);
            Rent::updateAll(['agent2_id' => null], ['agent2_id' => $id]);
            Rent::updateAll(['agent3_id' => null], ['agent3_id' => $id]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Course model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Course the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Agents::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}