<?php

namespace backend\controllers;

use backend\controllers\traits\ApartmentAgentTrait;
use backend\models\CustomerViewedAd;
use Yii;
use common\models\Apartment;
use common\models\Building;
use common\models\Rent;
use common\models\Area;
use common\models\Commercial;
use common\models\House;

use common\models\BuildingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\olxparser\models\Parser;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use backend\models\BuildingFind;
use backend\models\ModelData;
use backend\models\Condit;
use common\models\LivedComplex;
use yii\helpers\ArrayHelper;

/**
 * BuildingController implements the CRUD actions for Building model.
 */
class BuildingController extends Controller
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
     * Search on all site.
     */
    public function actionSearchallrealty()
    {
        return $this->asJson([
            'apartments' => $this->addCriteriaToQuery(Apartment::find()),
            'buildings' => $this->addCriteriaToQuery(Building::find()),
            'areas' => $this->addCriteriaToQuery(Area::find()),
            'rent' => $this->addCriteriaToQuery(Rent::find()),
            'commercial' => $this->addCriteriaToQuery(Commercial::find()),
            'houses' => $this->addCriteriaToQuery(House::find())
        ]);
    }

    private function addCriteriaToQuery($queryModel)
    {
        $id = Yii::$app->request->queryParams['MainSearch']['id'];
        $phone = Yii::$app->request->queryParams['MainSearch']['phone'];
        $result = [];

        if($id && $phone) {

            $result = $queryModel->where(
                [
                    'and',
                    ['=', 'id', $id],
                    ['like', 'phone', $phone]
                ]
        )->all();

        } elseif($id) {
            $result = $queryModel->where(['id' => $id])->all();
        } elseif($phone) {
            $result = $queryModel->where(['like', 'phone', $phone])->all();
        }

        return $result;
    }

    /**
     * Lists all Building models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BuildingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Building model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id,$customer_id=null)
    {
        $model = $this->findModel($id);
        $model->getResouseBoards('building');

        if($customer_id !== null){
            $viewedAd = new  CustomerViewedAd();
            if(!$viewedAd->checkIfAlreadyExists($model->id,$model::className())){
                $viewedAd->customer_id = $customer_id;
                $viewedAd->realty_id = $model->id;
                $viewedAd->realty_type_info = $model::className();
                $viewedAd->save();
            }
        }
        return $this->render('view', [
            'model' => $model,
            'lived_complex' => ModelData::getData()['lived_complex']
        ]);
    }

    /**
     * Creates a new Building model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Building();

        $model->deal_type_id = 2;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'data' => ModelData::getData(),
                'lived_complex' => LivedComplex::find()->select(['name', 'id'])->orderby('name')->indexBy('id')->column(),
                'agent' => ModelData::getCurrentAgentOnUserId($_SESSION['__id']),
                'hasMaxAgents' => ModelData::hasMaxAgents($model),
                'statesOldSite' => ArrayHelper::map(Condit::find()->where(['display_only_building' => 1])->asArray()->all(), 'condit_id', 'name')
            ]);
        }
    }

    /**
     * Updates an existing Building model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id,$customer_id=null)
    {
        $model = $this->findModel($id);
        $model->getResouseBoards('building');

        if($customer_id !== null){
            $viewedAd = new  CustomerViewedAd();
            if(!$viewedAd->checkIfAlreadyExists($model->id,$model::className())){
                $viewedAd->customer_id = $customer_id;
                $viewedAd->realty_id = $model->id;
                $viewedAd->realty_type_info = $model::className();
                $viewedAd->save();
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'data' => ModelData::getData(),
                'lived_complex' => LivedComplex::find()->select(['name', 'id'])->orderby('name')->indexBy('id')->column(),
                'agent' => ModelData::getCurrentAgentOnUserId($_SESSION['__id']),
                'hasMaxAgents' => ModelData::hasMaxAgents($model),
                'statesOldSite' => ArrayHelper::map(Condit::find()->where(['display_only_building' => 1])->asArray()->all(), 'condit_id', 'name')
            ]);
        }
    }

    /**
     * Deletes an existing Building model.
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
     * Finds the Building model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Building the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Building::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSearch()
    {

        // fill with previous values
        $values = Yii::$app->request->get('BuildingFind');
        $model = new BuildingFind();
        $model->attributes = $values;
        return $this->render('find', [
            'model' => $model,
            'statesOldSite' => ArrayHelper::map(Condit::find()->where(['display_only_building' => 1])->asArray()->all(), 'condit_id', 'name')
        ]);
    }

    public function actionSearchresult()
    {
        $model = new BuildingFind();
        $query = $model->search();

        //var_dump($query); exit;

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
        $model = new BuildingFind();
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
        $count = Building::find()->count();

        return $this->render('linkconvertor', ['count' => $count]);
    }

    public function actionLinkimages($start = 0)
    {
        $posts = Yii::$app->db->createCommand("SELECT * FROM building ORDER BY id desc LIMIT $start, 50")
            ->queryAll();
        foreach ($posts as $post)
        {
            $photos = Yii::$app->db->createCommand("SELECT * FROM photo WHERE  `type_realty_id`= 3 AND `object_id`= {$post['id']}")
                ->queryAll();
            if(!empty($photos))
            {
                foreach ($photos as $photo)
                {
                    $model = Building::findOne($post['id']);
                    $ph_path = explode('/upload/images', $photo['path']);
                    $path = Yii::getAlias('@webroot')."/../../upload/images".$ph_path['1'];
                    //$path = Yii::getAlias('@webroot')."/../..".$photo['path'];
                    if(file_exists($path)){
                        $model->attachImage($path);
                        //echo "ok ".$post['id']."--".$path."<br>";
                    }
                    //else
                    //    echo "no photo in folder by id". $post['id'] . "!!".$path."<br>";
                }}
            /*else
                echo "no photo by id". $post['id'] . "!!<br>";*/

        }
        $start += 50;
        echo $start;
    }

    public function actionFileDelete()
    {
        echo $id = Yii::$app->request->post('key');
        echo Building::deleteImage($id);
    }

    public function actionAddFromParser($id)
    {
        $parser_model = Parser::findOne($id);
        $building_model = new Building();
        $building_model->note = $parser_model->link;
        $building_model->type_object_id = $parser_model->type_object_id;
        $building_model->count_room = $parser_model->count_room;
        $building_model->floor = $parser_model->floor;
        $building_model->floor_all = $parser_model->floor_all;
        $building_model->total_area = $parser_model->total_area;
        $building_model->floor_area = $parser_model->floor_area;
        $building_model->kitchen_area = $parser_model->kitchen_area;
        $price = explode(' ',$parser_model->price);
        $building_model->price = intval(trim($price['0']).trim($price['1']));
        $building_model->source_info_id = 4;
        $building_model->phone = $parser_model->phone;
        $building_model->notesite = $parser_model->note;
        $images = unserialize($parser_model->image);


        if ($building_model->load(Yii::$app->request->post()) && $building_model->save()) {
            return $this->redirect(['view', 'id' => $building_model->id]);
        } else {
            return $this->render('update_from_parser', [
                'model' => $building_model, 'images' => $images
            ]);
        }
    }

    public function actionAdd()
    {
        $values = Yii::$app->request->post('Building');

        if($values['id'] !='')
        {
            $model = Building::findOne($values['id']);
            $model->attributes = $values;
        }
        else
        {
            $model = new Building();
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
        $model->date_modified_photo = date("Y-m-d H:i:s");
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
            $model->setResourseBoards('building');
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            $model->upload();
        }

        $data['id'] = $model->id;
        $apart = Building::findOne($data['id']);
        $apart->getResouseBoards('building');
        return $this->render('view', [
            'data' => $data,
            'model' => $apart,
            'lived_complex' => LivedComplex::find()->select(['name', 'id'])->orderby('name')->indexBy('id')->column(),
        ]);
    }
}
