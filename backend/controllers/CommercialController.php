<?php

namespace backend\controllers;

use backend\controllers\traits\ApartmentAgentTrait;
use Yii;
use common\models\Commercial;
use common\models\CommercialSearch;
use backend\models\ModelData;
use backend\models\CommercialFind;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use app\modules\olxparser\models\Parser;
/**
 * CommercialController implements the CRUD actions for Commercial model.
 */
class CommercialController extends Controller
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
        ];
    }

    /**
     * Lists all Commercial models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CommercialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Commercial model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->getResouseBoards('commercial');
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Commercial model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Commercial();

        $model->deal_type_id = 2;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            /*return $this->render('create', [
                'model' => $model,
            ]);*/
            return $this->render('update', [
                'model' => $model,
                'data' => ModelData::getData(),
                'agent' => ModelData::getCurrentAgentOnUserId($_SESSION['__id']),
                'hasMaxAgents' => ModelData::hasMaxAgents($model)
            ]);
        }
    }

    /**
     * Updates an existing Commercial model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->getResouseBoards('commercial');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //$model->setResourseBoards();
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'data' => ModelData::getData(),
                'agent' => ModelData::getCurrentAgentOnUserId($_SESSION['__id']),
                'hasMaxAgents' => ModelData::hasMaxAgents($model)
            ]);
        }
    }

    /**
     * Deletes an existing Commercial model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->enabled = 0;
        $model->update(false);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Commercial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Commercial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Commercial::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSearch()
    {
        // fill with previous values
        $values = Yii::$app->request->get('CommercialFind');
        $model = new CommercialFind();
        $model->attributes = $values;
        return $this->render('find', ['model' => $model]);
    }

    public function actionSearchresult()
    {
        $model = new CommercialFind();
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
        $model = new CommercialFind();
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
        $count = Commercial::find()->count();

        return $this->render('linkconvertor', ['count' => $count]);
    }

    public function actionLinkimages($start = 0)
    {
        $posts = Yii::$app->db->createCommand("SELECT * FROM commercial ORDER BY id desc LIMIT $start, 50")
            ->queryAll();
        foreach ($posts as $post)
        {
            $photos = Yii::$app->db->createCommand("SELECT * FROM photo WHERE  `type_realty_id`= 6 AND `object_id`= {$post['id']}")
                ->queryAll();
            if(!empty($photos))
            {
                foreach ($photos as $photo)
                {
                    $model = Commercial::findOne($post['id']);
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
        echo Commercial::deleteImage($id);
    }

    public function actionAdd()
    {
        $values = Yii::$app->request->post('Commercial');

        if($values['id'] !='')
        {
            $model = Commercial::findOne($values['id']);
            $model->attributes = $values;
        }
        else
        {
            $model = new Commercial();
            $model->attributes = $values;
            $model->date_added = date("Y-m-d H:i:s");
        }

        if ($model->is_publish) {
            $agent = ModelData::getCurrentAgentOnUserId(Yii::$app->user->id);
            $agentId = $agent ? $agent['id'] : null;
            if ($agentId !== null && !$this->isAgentAttachedToModel($agentId, $model)) {
                $this->addAgentIdToModel($agentId, $model);
            }
        }

        $model->date_modified = date("Y-m-d H:i:s");
        if(!$model['author_id']) $model['author_id'] = Yii::$app->user->id;
        else $model['update_author_id'] = Yii::$app->user->id;

        //if(!empty(UploadedFile::getInstances($model, 'imageFiles'))){ err WTF?
        if(UploadedFile::getInstances($model, 'imageFiles')){
            $model['update_photo_user_id'] = Yii::$app->user->id;
        }
        if($model->save()){
            $model->besplatka = $values['besplatka'];
            $model->est = $values['est'];
            $model->mesto = $values['mesto'];
            $model->setResourseBoards('commercial');
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            $model->upload();
        }

        $data['id'] = $model->id;
        $apart = Commercial::findOne($data['id']);
        $apart->getResouseBoards('commercial');
        return $this->render('view', ['data' => $data, 'model' => $apart]);
    }
}
