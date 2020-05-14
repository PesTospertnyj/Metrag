<?php

namespace api\modules\v1\controllers;

use backend\controllers\traits\ApartmentAgentTrait;
use backend\models\HouseFind;
use backend\models\ModelData;
use api\models\HouseSearch;
use sizeg\jwt\JwtHttpBearerAuth;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class HouseController extends Controller
{
    use ApartmentAgentTrait;

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
            'authenticator' => [
                'class' => JwtHttpBearerAuth::class,
            ]
        ];
    }

    /**
     * Lists all House models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HouseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->asJson([
            'items' => $dataProvider->query->all(),
            'status' => 200,
        ]);
    }


    /**
     * Creates a new House model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new \common\models\House();

        $model->deal_type_id = 2;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
     * Updates an existing House model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = House::findOne($id);
        if (!$model) {
            Yii::$app->response->statusCode = 404;

            return $this->asJson([
                'status' => 404,
            ]);
        }

        $model->getResouseBoards('house');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
     * Deletes an existing House model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->enabled = 0;
        $model->update(false);
        return $this->asJson(['status' => 200]);
    }

    /**
     * Finds the House model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return House the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = House::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSearch()
    {
        // fill with previous values
        $values = Yii::$app->request->get('HouseFind');
        $model = new HouseFind();
        $model->attributes = $values;
        return $this->render('find', ['model' => $model]);
    }

    public function actionSearchresult()
    {
        $model = new HouseFind();
        $query = $model->search();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);
        return $this->render('find-result', [
            'dataProvider' => $dataProvider,
            'data' => ModelData::getData()
        ]);
    }

    public function actionPrint(){
        $model = new HouseFind();
        $query = $model->search();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);
        return $this->render('print', ['dataProvider' => $dataProvider]);
    }

    public function actionLinkConvertor()
    {
        $count = House::find()->count();

        return $this->render('linkconvertor', ['count' => $count]);
    }

    public function actionLinkimages($start = 0)
    {
        $posts = Yii::$app->db->createCommand("SELECT * FROM house ORDER BY id desc LIMIT $start, 50")
            ->queryAll();
        foreach ($posts as $post)
        {
            $photos = Yii::$app->db->createCommand("SELECT * FROM photo WHERE  `type_realty_id`= 4 AND `object_id`= {$post['id']}")
                ->queryAll();
            if(!empty($photos))
            {
                foreach ($photos as $photo)
                {
                    $model = House::findOne($post['id']);
                    $ph_path = explode('/upload/images', $photo['path']);
                    $path = Yii::getAlias('@webroot')."/../../upload/images".$ph_path['1'];
                    if(file_exists($path)){
                        $model->attachImage($path);
                    }
                }}
        }
        $start += 50;
        echo $start;
    }

    public function actionFileDelete()
    {
        echo $id = Yii::$app->request->post('key');
        echo House::deleteImage($id);
    }

    public function actionAdd()
    {
        $values = Yii::$app->request->post('House');



        //var_dump($values); exit;


        if($values['id'] !='')
        {
            $model = House::findOne($values['id']);
            $model->attributes = $values;
        }
        else
        {
            $model = new House();
            $model->attributes = $values;
            $model->date_added = date("Y-m-d H:i:s");
        }
        $model->year_built = 0;

        if ($model->is_publish) {
            $agent = ModelData::getCurrentAgentOnUserId(Yii::$app->user->id);
            $agentId = $agent ? $agent['id'] : null;
            if ($agentId !== null && !$this->isAgentAttachedToModel($agentId, $model)) {
                $this->addAgentIdToModel($agentId, $model);
            }
        }

        $model->date_modified = date("Y-m-d H:i:s");
        $model->date_modified_photo = date("Y-m-d H:i:s");
        if(!$model['author_id']) $model['author_id'] = Yii::$app->user->id;
        else $model['update_author_id'] = Yii::$app->user->id;

        if(UploadedFile::getInstances($model, 'imageFiles')){
            $model['update_photo_user_id'] = Yii::$app->user->id;
        }
        if($model->save()){
            $model->besplatka = $values['besplatka'];
            $model->est = $values['est'];
            $model->mesto = $values['mesto'];
            $model->setResourseBoards('house');
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            $model->upload();
        }

        $data['id'] = $model->id;
        $apart = House::findOne($data['id']);
        $apart->getResouseBoards('house');
        return $this->render('view', ['data' => $data, 'model' => $apart]);
    }
}
