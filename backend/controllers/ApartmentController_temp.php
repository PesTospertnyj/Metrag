<?php

namespace backend\controllers;

use app\modules\parsercd\models\Parsercd;
use Yii;
use common\models\Apartment;
use common\models\ApartmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

use backend\models\ApartmentFind;
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
        $model = $this->findModel($id);
        $model->getResouseBoards('apartment');
        return $this->render('view', [
            'model' => $model,
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
        $model->getResouseBoards('apartment');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //$model->setResourseBoards();
            //return $this->redirect(['view', 'id' => $model->id]);
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

    public function actionSearch()
    {
        // fill with previous values
        $values = Yii::$app->request->get('ApartmentFind');
        $model = new ApartmentFind();
        $model->attributes = $values;
        return $this->render('find', ['model' => $model]);
    }

    public function actionSearchresult()
    {
        $model = new ApartmentFind();
        //$searchModel = new ApartmentSearch();
        $query = $model->search();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('find-result', ['dataProvider' => $dataProvider]);
    }

    public function actionPrint(){
        $model = new ApartmentFind();
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
        echo Apartment::deleteImage($id);
    }

    public function actionAddFromParser($id)
    {
        $parser_model = Parser::findOne($id);
        $apartment_model = new Apartment();
        $apartment_model->note = $parser_model->link;
        $apartment_model->type_object_id = $parser_model->type_object_id;
        $apartment_model->count_room = $parser_model->count_room;
        $apartment_model->floor = $parser_model->floor;
        $apartment_model->floor_all = $parser_model->floor_all;
        $apartment_model->total_area = $parser_model->total_area;
        $apartment_model->floor_area = $parser_model->floor_area;
        $apartment_model->kitchen_area = $parser_model->kitchen_area;
        $price = explode(' ',$parser_model->price);
        $apartment_model->price = intval(trim($price['0']).trim($price['1']));
        $apartment_model->source_info_id = 4;
        $apartment_model->phone = $parser_model->phone;
        $apartment_model->notesite = $parser_model->note;
        $images = unserialize($parser_model->image);

        if ($apartment_model->load(Yii::$app->request->post()) && $apartment_model->save()) {
            return $this->redirect(['view', 'id' => $apartment_model->id]);
        } else {
            return $this->render('update_from_parser', [
                'model' => $apartment_model, 'images' => $images
            ]);
        }
    }

    public function actionAddFromParsercd($id)
    {
        $parser_model = Parsercd::findOne($id);
        $apartment_model = new Apartment();
        $apartment_model->note = $parser_model->link1 . ', ' . $parser_model->link2;
        $apartment_model->type_object_id = $parser_model->type_object_id;
        $apartment_model->count_room = $parser_model->count_room;
        $apartment_model->floor = $parser_model->floor;
        $apartment_model->floor_all = $parser_model->floor_all;
        $apartment_model->total_area = $parser_model->total_area;
        $apartment_model->floor_area = $parser_model->floor_area;
        $apartment_model->kitchen_area = $parser_model->kitchen_area;
        $apartment_model->price = $parser_model->price;
        $apartment_model->source_info_id = 5;
        $apartment_model->phone = $parser_model->phone;
        $apartment_model->notesite = $parser_model->note;
        $apartment_model->region_kharkiv_id = $parser_model->region_kharkiv_id;
        $apartment_model->street_id = $parser_model->street_id;
        $apartment_model->metro_id = $parser_model->metro_id;

        if ($apartment_model->load(Yii::$app->request->post()) && $apartment_model->save()) {
            return $this->redirect(['view', 'id' => $apartment_model->id]);
        } else {
            return $this->render('update_from_parsercd', [
                'model' => $apartment_model
            ]);
        }
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
        $model->date_modified = date("Y-m-d H:i:s");
        if(!$model['author_id']) $model['author_id'] = Yii::$app->user->id;
        else $model['update_author_id'] = Yii::$app->user->id;

        if(UploadedFile::getInstances($model, 'imageFiles')){
            $model['update_photo_user_id'] = Yii::$app->user->id;
        }
        if($model->save()){
            $model->besplatka = $values['besplatka'];
            $model->est = $values['est'];
            $model->mesto = $values['mesto'];
            $model->setResourseBoards('apartment');
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            $model->upload();
        }

        $data['id'] = $model->id;
        $apart = Apartment::findOne($data['id']);
        $apart->getResouseBoards('apartment');
        return $this->render('view', ['data' => $data, 'model' => $apart]);
    }


}
