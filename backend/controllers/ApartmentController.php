<?php

namespace backend\controllers;

use app\modules\parsercd\models\Parsercd;
use backend\controllers\traits\ApartmentAgentTrait;
use backend\models\Street;
use Yii;
use common\models\Apartment;
use common\models\Area;
use common\models\Building;
use common\models\House;
use common\models\Commercial;
use common\models\Rent;
use common\models\ApartmentSearch;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use backend\models\ApartmentFind;

use backend\models\ModelData;

/**
 * ApartmentController implements the CRUD actions for Apartment model.
 */
class ApartmentController extends Controller
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


    public function actionRealty()
    {
        $matches1 = [];
        preg_match('|.*/admin/(.*)/|', $_SERVER['HTTP_REFERER'], $matches1);
        $type = $matches1[1];

        $matches2 = [];
        preg_match('|id=(\d+)|', $_SERVER['HTTP_REFERER'], $matches2);
        $id = $matches2[1];

        $agentId = (int)ModelData::getCurrentAgentId();

        if(!$agentId) {
            return $this->asJson([
                'error' => 'Агент не связан с пользователем. Укажите связь на странице https://metrag.com.ua/admin/agents'
            ]);
        }

        $model = null;
        if ($type === 'apartment') {
            $model = Apartment::find()
                ->where(['id' => $id])
                ->one();
        } elseif ($type === 'building') {
            $model = Building::find()
                ->where(['id' => $id])
                ->one();
        } elseif ($type === 'house') {
            $model = House::find()
                ->where(['id' => $id])
                ->one();
        } elseif ($type === 'area') {
            $model = Area::find()
                ->where(['id' => $id])
                ->one();
        } elseif ($type === 'commercial') {
            $model = Commercial::find()
                ->where(['id' => $id])
                ->one();
        }

        if (!$model) {
            return $this->asJson([
                'error' => 'Произошла ошибка. Не верный тип.'
            ]);
        }

        if ($model->agent1_id === $agentId || $model->agent2_id === $agentId || $model->agent3_id === $agentId) {
            return $this->asJson([
                'error' => 'Вы выбрали этот объект раннее.'
            ]);
        }

        if (!$this->addAgentIdToModel($agentId, $model)) {
            return $this->asJson([
                'error' => 'Ошибка: максимально колличество агентов для объекта: 3'
            ]);
        }

        if ($model->save()) {
            return $this->asJson([
                'result' => 'Агент был добавлен к объекту',
                'refresh' => true
            ]);
        }

        return $this->asJson([
            'result' => 'Произошла ошибка, попробуйте повторить попытку'
        ]);
    }

    /**
     * Lists all Apartment models.
     * @return mixed
     */
    public function actionIndex()
    {
        //old***********
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

        $model->deal_type_id = 2;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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
                'data' => ModelData::getData(),
                'agent' => ModelData::getCurrentAgentOnUserId($_SESSION['__id']),
                'hasMaxAgents' => ModelData::hasMaxAgents($model)
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

    public function actionPrint()
    {
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
        try {
            $posts = Yii::$app->db->createCommand("SELECT * FROM apartment ORDER BY id desc LIMIT $start, 50")
                ->queryAll();
            foreach ($posts as $post) {
                $photos = Yii::$app->db->createCommand("SELECT * FROM photo WHERE  `type_realty_id`= 2 AND `object_id`= {$post['id']}")
                    ->queryAll();
                if (!empty($photos)) {
                    foreach ($photos as $photo) {
                        $model = Apartment::findOne($post['id']);
                        $ph_path = explode('/upload/images', $photo['path']);
                        $path = Yii::getAlias('@webroot') . "/../../upload/images" . $ph_path['1'];
                        if (file_exists($path)) {
                            $model->attachImage($path);
                        }
                    }
                }
            }
            $start += 50;
        } catch (Exception $exception) {
            echo $start;
            echo $exception->getMessage();
            die;
        }


        echo $start;
    }

    public function actionFileDelete()
    {
        echo $id = Yii::$app->request->post('key');
        echo Apartment::deleteImage($id);
    }

    public function actionAddFromParserOld($id)
    {
        $parser_model = Parser::findOne($id);
        $match = Apartment::find()->where(['count_room' => $parser_model->count_room, 'floor' => $parser_model->floor, 'floor_all' => $parser_model->floor_all,
            'total_area' => $parser_model->total_area, 'floor_area' => $parser_model->floor_area,
            'phone' => $parser_model->phone == 'no phone' ? '00000000' : $parser_model->phone])->one();
        if ($match) {
            \Yii::$app->session->addFlash("error", "Такая квартира уже есть в базе!");
            return $this->redirect(['view',
                'id' => $match->id
            ]);
        }
        $apartment_model = new Apartment();
        $apartment_model->note = $parser_model->link;
        $apartment_model->type_object_id = $parser_model->type_object_id;
        $apartment_model->count_room = $parser_model->count_room;
        $apartment_model->floor = $parser_model->floor;
        $apartment_model->floor_all = $parser_model->floor_all;
        $apartment_model->city_or_region = 0;
        $apartment_model->total_area = $parser_model->total_area;
        $apartment_model->floor_area = $parser_model->floor_area;
        $apartment_model->kitchen_area = $parser_model->kitchen_area;
        $price = explode(' ', $parser_model->price);
        $apartment_model->price = intval(trim($price['0']) . trim($price['1']));
        $apartment_model->source_info_id = 4;
        $apartment_model->bath = 0;
        $apartment_model->enabled = 1;
        $apartment_model->phone = $parser_model->phone == 'no phone' ? '00000000' : $parser_model->phone;
        $apartment_model->notesite = $parser_model->note;

        if ($apartment_model->save(false)) {
            $apartment_model->imageFiles = unserialize($parser_model->image);
            $apartment_model->uploadOlx();
        }
        \Yii::$app->session->addFlash("success", "Объявление добавлено в базу!<br>Отредактируйте дополнительную информацию...");
        $parser_model->enabled = 0;
        $parser_model->save(false);
        return $this->redirect(['update',
            'id' => $apartment_model->id
        ]);

    }

    public function actionAddFromParser($id)
    {
        $parser_model = Parser::findOne($id);

        $match = Apartment::find()->where(['count_room' => $parser_model->count_room, 'floor' => $parser_model->floor, 'floor_all' => $parser_model->floor_all,
            'total_area' => $parser_model->total_area, 'floor_area' => $parser_model->floor_area,
            'phone' => $parser_model->phone == 'no phone' ? '00000000' : $parser_model->phone])->one();
        if ($match) {
            \Yii::$app->session->addFlash("error", "Такая квартира уже есть в базе!");
            return $this->redirect(['view',
                'id' => $match->id
            ]);
        }

        $apartment_model = new Apartment();
        $apartment_model->note = $parser_model->link;
        $apartment_model->type_object_id = $parser_model->type_object_id;
        $apartment_model->count_room = $parser_model->count_room;
        $apartment_model->floor = $parser_model->floor;
        $apartment_model->floor_all = $parser_model->floor_all;
        $apartment_model->city_or_region = 0;
        $apartment_model->total_area = $parser_model->total_area;
        $apartment_model->floor_area = $parser_model->floor_area;
        $apartment_model->kitchen_area = $parser_model->kitchen_area;
        $price = explode(' ', $parser_model->price);
        $apartment_model->price = intval(trim($price['0']) . trim($price['1']));
        $apartment_model->source_info_id = 4;
        $apartment_model->bath = 0;
        $apartment_model->enabled = 1;
        $apartment_model->phone = $parser_model->phone == 'no phone' ? '00000000' : $parser_model->phone;
        $apartment_model->notesite = $parser_model->note;
        $images = unserialize($parser_model->image);

        //no user & date fix
        $apartment_model->author_id = Yii::$app->user->id;
        $apartment_model->update_author_id = Yii::$app->user->id;
        $apartment_model->update_photo_user_id = Yii::$app->user->id;
        $apartment_model->date_added = date("Y-m-d H:i:s");
        $apartment_model->date_modified = date("Y-m-d H:i:s");

        if ($apartment_model->load(Yii::$app->request->post()) && $apartment_model->save()) {
            $apartment_model->imageFiles = unserialize($parser_model->image);
            $apartment_model->uploadOlx();
            //$apartment_model->upload();
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

        //no user & date fix
        $apartment_model->author_id = Yii::$app->user->id;
        $apartment_model->update_author_id = Yii::$app->user->id;
        $apartment_model->update_photo_user_id = Yii::$app->user->id;
        $apartment_model->date_added = date("Y-m-d H:i:s");
        $apartment_model->date_modified = date("Y-m-d H:i:s");

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
        if ($values['id'] != '') {
            $model = Apartment::findOne($values['id']);
            $model->attributes = $values;
        } else {
            $model = new Apartment();
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
        if (!$model['author_id']) $model['author_id'] = Yii::$app->user->id;
        else $model['update_author_id'] = Yii::$app->user->id;


        if (UploadedFile::getInstances($model, 'imageFiles')) {
            $model['update_photo_user_id'] = Yii::$app->user->id;
        }
        if ($model->save()) {
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

    public function actionFileUpload()
    {

        if (empty($_FILES['Apartment'])) {
            echo json_encode(['error' => 'No files found for upload.']);
        }
        // upload.php
        // 'images' refers to your file input name attribute
        if (empty($_FILES['Apartment'])) {
            echo json_encode(['error' => 'No files found for upload.']);
            // or you can throw an exception
            return; // terminate
        }

// get the files posted
        $model = new Apartment();
        $images = $model->uploadImages();

// a flag to see if everything is ok
        $success = null;

// file paths to store
        $paths = [];

// get file names
        $filenames = $images['name'];
        echo json_encode(['error' => "name - $filenames"]);
        //echo json_encode("name - $filenames");
// loop and process files
        /*
        for($i=0; $i < count($filenames); $i++){
            $ext = explode('.', basename($filenames[$i]));
            $target = "uploads" . DIRECTORY_SEPARATOR . md5(uniqid()) . "." . array_pop($ext);
            if(move_uploaded_file($images['tmp_name'][$i], $target)) {
                $success = true;
                $paths[] = $target;
            } else {
                $success = false;
                break;
            }
        }

// check and process based on successful status
        if ($success === true) {
            // call the function to save all data to database
            // code for the following function `save_data` is not
            // mentioned in this example
            save_data($userid, $username, $paths);

            // store a successful response (default at least an empty array). You
            // could return any additional response info you need to the plugin for
            // advanced implementations.
            $output = [];
            // for example you can get the list of files uploaded this way
            // $output = ['uploaded' => $paths];
        } elseif ($success === false) {
            $output = ['error'=>'Error while uploading images. Contact the system administrator'];
            // delete any uploaded files
            foreach ($paths as $file) {
                unlink($file);
            }
        } else {
            $output = ['error'=>'No files were processed.'];
        }

// return a json encoded response for plugin to process successfully
        echo json_encode($output);*/
    }

    public function actionTestupload()
    {
        return $this->render('testupload');
    }


}
