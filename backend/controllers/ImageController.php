<?php

namespace backend\controllers;

use Yii;
use backend\models\Image;
use backend\models\ImageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ImageController implements the CRUD actions for Image model.
 */
class ImageController extends Controller
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

    public function actionGetpreviewid()
    {
        $matches1 = [];
        preg_match('|.*/admin/(.*)/|', $_SERVER['HTTP_REFERER'], $matches1);
        $type = ucfirst($matches1[1]);

        $matches2 = [];
        preg_match('|id=(\d+)|', $_SERVER['HTTP_REFERER'], $matches2);
        $id = $matches2[1];


        $model = Image::find()->where(['modelName' => $type, 'itemId' => $id, 'isPreview' => true])->one();
        if(!$model) {
            $model = Image::find()->where(['modelName' => $type, 'itemId' => $id])->one();
        }


        if($model) {
            return $this->asJson([
                'id' => $model->id
            ]);
        }
        return $this->asJson([
            'is_not_found' => true
        ]);

    }

    public function actionPreview()
    {
        $matches1 = [];
        preg_match('|.*/admin/(.*)/|', $_SERVER['HTTP_REFERER'], $matches1);
        $type = ucfirst($matches1[1]);

        $matches2 = [];
        preg_match('|id=(\d+)|', $_SERVER['HTTP_REFERER'], $matches2);
        $id = $matches2[1];

        $model = Image::find()->where(['modelName' => $type, 'itemId' => $id])->one();

        if(!$model) {
            return $this->asJson([
                'error' => 'Изображение не найденно'
            ]);
        }

        //set previews = 0
        Image::updateAll(
            ['isPreview' => false],
            [
                'and',
                ['=', 'modelName', $type],
                ['=', 'itemId', $id]
            ]
        );

        $model = Image::findOne(Yii::$app->request->post('id'));
        if(!$model) {
            return $this->asJson([
                'error' => 'Изображение для изменения не найденно'
            ]);
        }

        $model->isPreview = true;
        if($model->save()) {
            return $this->asJson([
                'result' => 'Обложка успешно выбранна'
            ]);
        }
    }

    /**
     * Lists all Image models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Image model.
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
     * Creates a new Image model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Image();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Image model.
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
     * Deletes an existing Image model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Image model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Image the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Image::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
