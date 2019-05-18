<?php

namespace backend\controllers;

use Yii;
use backend\models\Apartment;
use backend\models\ApartmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

use backend\models\ApartmentFind;
use backend\models\RegionKharkivAdmin;
use backend\models\TypeObject;
use backend\models\Locality;
use backend\models\RegionKharkiv;
use backend\models\Region;
use backend\models\Street;
use backend\models\Course;
use backend\models\WallMaterial;
use backend\models\Condit;
use backend\models\Wc;
use backend\models\Users;
use backend\models\UserType;
use backend\models\Layout;

use app\modules\olxparser\models\Parser;
/**
 * ApartmentController implements the CRUD actions for Apartment model.
 */
class ApartmentController extends Controller
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
     * Lists all Apartment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ApartmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Apartment model.
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
     * Creates a new Apartment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Apartment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            /*return $this->render('create', [
                'model' => $model,
            ]);*/
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }



    /**
     * Updates an existing Apartment model.
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
     * Deletes an existing Apartment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->enabled = 0;
        $model->update(false);
        var_dump($model);
        die;
        return $this->redirect(['index']);
    }

    /**
     * Finds the Apartment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Apartment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Apartment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //-------------------------------------------------

    public function actionSearch()
    {
        $model = [];

        $model['ApartmentFind'] = new ApartmentFind();
        $model['RegionKharkivAdmin'] = new RegionKharkivAdmin();
        $model['TypeObject'] = new TypeObject();
        $model['Locality'] = new Locality();
        $model['Layout'] = new Layout();
        $model['RegionKharkiv'] = new RegionKharkiv();
        $model['Region'] = new Region();
        $model['Street'] = new Street();
        $model['Course'] = new Course();
        $model['WallMaterial'] = new WallMaterial();
        $model['Condit'] = new Condit();
        $model['Wc'] = new Wc();
        $model['Users'] = new Users();
        $model['UserType'] = new UserType();

        if (Yii::$app->request->post()) {

            //$url = Url::toRoute('/agency/testview');
            //return $this->redirect($url);

            //$post = Yii::$app->request->post();
            
            //print_r($post);
            /*
            $dataProvider = $this->getSearchResult($post);



            return $this->render('search-result',
            ['post' => $post, 'dataProvider' => $dataProvider]);
            */
            //return $this->render('apartments', ['post' => $post]);
        } else {
            // страница отображается первый раз
            return $this->render('find', ['model' => $model]);
        }
        
    }

    public function actionSearchresult()
    {
        $get = Yii::$app->request->get();

        $query = Apartment::find();
        //echo $get['ApartmentFind']['date_addedTo'];
        //echo Yii::$app->formatter->asDateTime($get['ApartmentFind']['date_addedFrom'], 'yyyy-MM-dd HH:mm:ss');
        //die;

        //$query = (new \yii\db\Query())->from('apartment');

        
        if(!empty($get['ApartmentFind']['idFrom']))
        $query->andFilterWhere(['>=', 'id', $get['ApartmentFind']['idFrom']]);
        if(!empty($get['ApartmentFind']['idTo']))
        $query->andFilterWhere(['<=', 'id', $get['ApartmentFind']['idTo']]);
        if(!empty($get['ApartmentFind']['count_roomFrom']))
        $query->andFilterWhere(['>=', 'count_room', $get['ApartmentFind']['count_roomFrom']]);
        if(!empty($get['ApartmentFind']['count_roomTo']))
        $query->andFilterWhere(['<=', 'count_room', $get['ApartmentFind']['count_roomTo']]);
        if(!empty($get['ApartmentFind']['priceFrom']))
        $query->andFilterWhere(['>=', 'price', $get['ApartmentFind']['priceFrom']]);
        if(!empty($get['ApartmentFind']['priceTo']))
        $query->andFilterWhere(['<=', 'price', $get['ApartmentFind']['priceTo']]);
        if(!empty($get['ApartmentFind']['floorFrom']))
        $query->andFilterWhere(['>=', 'floor', $get['ApartmentFind']['floorFrom']]);
        if(!empty($get['ApartmentFind']['floorTo']))
        $query->andFilterWhere(['<=', 'floor', $get['ApartmentFind']['floorTo']]);
        if(!empty($get['ApartmentFind']['floorFrom']))
        $query->andFilterWhere(['>=', 'floor', $get['ApartmentFind']['floorFrom']]);
        if(!empty($get['ApartmentFind']['floorTo']))
        $query->andFilterWhere(['<=', 'floor', $get['ApartmentFind']['floorTo']]);
        if(!empty($get['ApartmentFind']['total_areaFrom']))
        $query->andFilterWhere(['>=', 'total_area', $get['ApartmentFind']['total_areaFrom']]);
        if(!empty($get['ApartmentFind']['total_areaTo']))
        $query->andFilterWhere(['<=', 'total_area', $get['ApartmentFind']['total_areaTo']]);
        if(!empty($get['ApartmentFind']['floor_areaFrom']))
        $query->andFilterWhere(['>=', 'floor_area', $get['ApartmentFind']['floor_areaFrom']]);
        if(!empty($get['ApartmentFind']['floor_areaTo']))
        $query->andFilterWhere(['<=', 'floor_area', $get['ApartmentFind']['floor_areaTo']]);
        if(!empty($get['ApartmentFind']['kitchen_areaFrom']))
        $query->andFilterWhere(['>=', 'kitchen_area', $get['ApartmentFind']['kitchen_areaFrom']]);
        if(!empty($get['ApartmentFind']['kitchen_areaTo']))
        $query->andFilterWhere(['<=', 'kitchen_area', $get['ApartmentFind']['kitchen_areaTo']]);
        //if(!empty($get['ApartmentFind']['date_addedFrom']))
        //        $query->andFilterWhere(['>=', 'date_added', $get['ApartmentFind']['kitchen_areaFrom']]);
        //if(!empty($get['ApartmentFind']['date_addedTo']))
        //        $query->andFilterWhere(['<=', 'date_added', $get['ApartmentFind']['date_addedTo']]);
        
        if(!empty($get['ApartmentFind']['date_addedFrom']))
                $query->andFilterWhere(['>=', 'date_added', Yii::$app->formatter->asDateTime($get['ApartmentFind']['date_addedFrom'], 'yyyy-MM-dd HH:mm:ss')]);
        if(!empty($get['ApartmentFind']['date_addedTo']))
                $query->andFilterWhere(['<=', 'date_added', Yii::$app->formatter->asDateTime($get['ApartmentFind']['date_addedTo'], 'yyyy-MM-dd HH:mm:ss')]);

        if(!empty($get['TypeObject']['type_object_id']))
        $query->andwhere(['type_object_id' => $get['TypeObject']['type_object_id']]);
        if(!empty($get['RegionKharkivAdmin']['region_kharkiv_admin_id']))
        $query->andwhere(['region_kharkiv_admin_id' => $get['RegionKharkivAdmin']['region_kharkiv_admin_id']]);
        if(!empty($get['RegionKharkiv']['region_kharkiv_id']))
        $query->andwhere(['region_kharkiv_id' => $get['RegionKharkiv']['region_kharkiv_id']]);
        if(!empty($get['Region']['region_id']))
        $query->andwhere(['region_id' => $get['Region']['region_id']]);
        if(!empty($get['Locality']['locality_id']))
        $query->andwhere(['locality_id' => $get['Locality']['locality_id']]);
        if(!empty($get['Course']['course_id']))
        $query->andwhere(['course_id' => $get['Course']['course_id']]);
        if(!empty($get['Street']['street_id']))
        $query->andwhere(['street_id' => $get['Street']['street_id']]);
        if(!empty($get['WallMaterial']['wall_material_id']))
        $query->andwhere(['wall_material_id' => $get['WallMaterial']['wall_material_id']]);
        if(!empty($get['Condit']['condit_id']))
        $query->andwhere(['condit_id' => $get['Condit']['condit_id']]);
        if(!empty($get['Wc']['wc_id']))
        $query->andwhere(['wc_id' => $get['Wc']['wc_id']]);
        if(!empty($get['Users']['update_author_id']))
        $query->andwhere(['update_author_id' => $get['Users']['update_author_id']]);
        if(!empty($get['Users']['author_id']))
        $query->andwhere(['author_id' => $get['Users']['author_id']]);
        if(!empty($get['Users']['update_photo_user_id']))
        $query->andwhere(['update_photo_user_id' => $get['Users']['update_photo_user_id']]);
        if(!empty($get['Users']['exclusive_user_id']))
        $query->andwhere(['exclusive_user_id' => $get['Users']['exclusive_user_id']]);
        
        if($get['ApartmentFind']['middle_floor'] == '0'){
            $query->andWhere(['floor' => '1']);    
            //$query->orWhere(['like', 'floor', apartment.floor_all]);    
        }

        $query->andwhere(['enabled' => '1']);
        
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        
        //$searchModel = new ApartmentSearch();
        $searchModel = new ApartmentFind();
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);


        return $this->render('find-result', ['dataProvider' => $dataProvider]);
    }

    public function actionAdd()
    {
        $values = Yii::$app->request->post('Apartment');
        if($values['id'] !='')
        {
            $model = Apartment::findOne($values['id']);
        }
        else
        {
            $model = new Apartment();
        }
        
        $model->attributes = $values;
        if(!$model['author_id']) $model['author_id'] = Yii::$app->user->id;
        else $model['update_author_id'] = Yii::$app->user->id;
        if(!empty(UploadedFile::getInstances($model, 'imageFiles')))
            $model['update_photo_user_id'] = Yii::$app->user->id;
        if($model->save()){
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            $model->upload();
        }
        
        $data['id'] = $model->id;
        $apart = Apartment::findOne($data['id']);
        return $this->render('view', ['data' => $data, 'model' => $apart]);
    }

    public function actionLinkConvertor()
    {
        $count = Apartment::find()->count();

        return $this->render('linkconvertor', ['count' => $count]);
    }

    public function actionLinkimages($start = 0)
    {
        $posts = Yii::$app->db->createCommand("SELECT * FROM apartment ORDER BY id desc LIMIT $start, 50")
                ->queryAll();
            foreach ($posts as $post)
            {
                $photos = Yii::$app->db->createCommand("SELECT * FROM photo WHERE  `type_realty_id`= 2 AND `object_id`= {$post['id']}")
                    ->queryAll();
                if(!empty($photos))  
                {
                    foreach ($photos as $photo)
                            {
                                $model = Apartment::findOne($post['id']);
                                $ph_path = explode('/upload/images', $photo['path']);
                                $path = Yii::getAlias('@webroot')."/../../upload".$ph_path['1'];
                                //$path = Yii::getAlias('@webroot')."/../..".$photo['path'];
                                if(file_exists($path)){
                                $model->attachImage($path);
                                //echo "ok ".$post['id']."--".$path."<br>";
                                }
                                /*else
                                    echo "no photo in folder by id". $post['id'] . "!!".$path."<br>";*/
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
        echo Apartment::deleteImage($id);
    }

    public function actionAddFromParser($id)
    {
        $parser_model = Parser::findOne($id);
        $apartment_model = new Apartment();
        $apartment_model->note = $parser_model->link;
        $apartment_model->type_object_id = $parser_model->type_object_id;
        //$apartment_model->type_object_id = $parser_model->type;
        $apartment_model->count_room = $parser_model->count_room;
        $apartment_model->floor = $parser_model->floor;
        $apartment_model->floor_all = $parser_model->floor_all;
        $apartment_model->total_area = $parser_model->total_area;
        $apartment_model->floor_area = $parser_model->floor_area;
        $apartment_model->kitchen_area = $parser_model->kitchen_area;
        //$apartment_model->price = $parser_model->price;
        $apartment_model->phone = $parser_model->phone;
        $apartment_model->notesite = $parser_model->note;
        //$parser_model->image;

        if ($apartment_model->load(Yii::$app->request->post()) && $apartment_model->save()) {
            return $this->redirect(['view', 'id' => $apartment_model->id]);
        } else {
            /*return $this->render('create', [
                'model' => $model,
            ]);*/
            return $this->render('update', [
                'model' => $apartment_model,
            ]);
        }
    }
}
