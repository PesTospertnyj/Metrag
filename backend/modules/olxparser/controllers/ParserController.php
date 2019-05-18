<?php

namespace app\modules\olxparser\controllers;

use Yii;
use app\modules\olxparser\models\Parser;
use app\modules\olxparser\models\ParserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use backend\controllers\ApartmentController;
use app\models\Apartment;

/**
 * ParserController implements the CRUD actions for Parser model.
 */
class ParserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Parser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ParserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Parser model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Parser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Parser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Parser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Parser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    /*public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['default/index']);
    }*/

    public function actionDelete($id, $page, $sort)
    {
        //$this->findModel($id)->delete();
        $model = $this->findModel($id);
        $model->enabled = 0;
        $model->save(false);
        $url = '';
        if($page)
        {
            $url .= 'page='.$page;
        }else{
            $url .= 'page=1';
        }
        if($sort)
        {
            $url .= '&sort='.$sort;
        }

        return $this->redirect(["default/index?$url"]);
    }

    public function actionAdd($id)
    {
        $parser_model = $this->findModel($id);
        ApartmentController::actionTest($parser_model);
        //return $this->redirect(['@app/views/apartment/index']);

    }

    /**
     * Finds the Parser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Parser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Parser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
