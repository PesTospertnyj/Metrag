<?php
namespace frontend\controllers;

use backend\models\Agents;
use common\models\Area;
use common\models\LivedComplex;
use common\models\Building;
use common\models\Commercial;
use common\models\House;
use common\models\Rent;
use frontend\models\ApartmentSearch;
use frontend\models\AreaSearch;
use frontend\models\BuildingSearch;
use frontend\models\CommercialSearch;
use frontend\models\HouseSearch;
use frontend\models\RentSearch;
use Yii;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;

use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

use common\models\CompanyInfo;
use common\models\Addsite;
use common\models\Apartment;
use common\models\Review;
use common\models\News;
use common\models\Article;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    private function transformImagesToString($images)
    {
        $imagesArr = [];
        foreach($images as $image) {
            if($image['isPreview']) {
                array_unshift($imagesArr, $image['filePath']);
            } else {
                $imagesArr[] = $image['filePath'];
            }
        }
        return $imagesArr;
    }
    private function transformApartments(array $apartments)
    {
        $response = [];

        foreach($apartments as $apartment) {
            $response[] = [
                'foreign_id' => $apartment['id'],
                'realty_type_id' => 1,
                'price' => $apartment['price'],
                'district_id' => $apartment['region_kharkiv_admin_id'],
                'metro_id' => $apartment['metro_id'],
                'rooms' => $apartment['count_room'],
                //'street' => $apartment->street->name,
                'street' => $apartment->street,
                'number_building' => $apartment->number_building,
                //'street_name' => $apartment->street->name,
                'state_id' => $apartment->realty_state_id,
                'total_area' => $apartment->total_area,
                'square_living' => $apartment->floor_area,
                'square_kitchen' => $apartment->kitchen_area,
                'year_built' => $apartment->year_built,
                'bathroom_type' => $apartment->bathroom_type,
                'floor' => $apartment->floor,
                'floor_all' => $apartment->floor_all,
                'layout_id' => $apartment->layout->layout_id,
                'wc_id' => $apartment->wc_id,
                'count_balcony' => $apartment->count_balcony,
                'count_balcony_glazed' => $apartment->count_balcony_glazed,
                //1 - аренда. 2 - покупка
                'deal_type_id' => 2,
                'status_id' => $apartment->status_publication,
                'description' => $apartment->notesite,
                'status_publication' => $apartment->status_publication,
                'sub_type_id' => $apartment->sub_type_id,
                'date' => $apartment->date_modified ? $apartment->date_modified : $apartment->date_added,
                'images' => $this->transformImagesToString($apartment->getImages()),
                'agents' => [
                    $apartment->agent1_id,
                    $apartment->agent2_id,
                    $apartment->agent3_id,
                ]
            ];
        }
        return $response;
    }
    private function transformRent(array $rents, $type)
    {
        $response = [];

        foreach($rents as $rent) {
            $response[] = [
                'foreign_id' => $rent['id'],
                'realty_type_id' => $type,
                'price' => $rent['price'],
                'district_id' => $rent['region_kharkiv_admin_id'],
                'metro_id' => $rent['metro_id'],
                'rooms' => $rent['count_room'],
                'street' => $rent->street,
                'number_building' => $rent->number_building,
                //'street_name' => $rent->street->name,
                'state_id' => $rent->realty_state_id,
                'total_area' => 0,
                'square_living' => 0,
                'square_kitchen' => 0,
                'year_built' => $rent->year_built,
                'bathroom_type' => $rent->bathroom_type,
                'floor' => $rent->floor,
                'floor_all' => $rent->floor_all,
                'layout_id' => null,
                'wc_id' => null,
                'status_id' => $rent->status_publication,
                'count_balcony' => null,
                'count_balcony_glazed' => null,
                //1 - аренда. 2 - покупка
                'deal_type_id' => 1,
                'description' => $rent->notesite,
                'status_publication' => $rent->status_publication,
                'sub_type_id' => $rent->sub_type_id,
                'date' => $rent->date_modified ? $rent->date_modified : $rent->date_added,
                'images' => $this->transformImagesToString($rent->getImages()),
                'agents' => [
                    $rent->agent1_id,
                    $rent->agent2_id,
                    $rent->agent3_id,
                ]
            ];
        }
        return $response;
    }
    private function transformHouses(array $houses)
    {
        $response = [];

        foreach($houses as $house) {
            $response[] = [
                'foreign_id' => $house['id'],
                'realty_type_id' => 5,
                'price' => $house['price'],
                'district_id' => $house['region_kharkiv_admin_id'],
                'metro_id' => $house['metro_id'],
                'rooms' => $house['count_room'],
                'street' => $house->street,
                'number_building' => $house->number_building,
                //'street_name' => $house->street->name,
                'state_id' => $house->realty_state_id,
                'total_area' => $house->total_area_house,
                //'square_living' => $house->floor_area,
                'square_living' => 0,
                'square_plot' => $house->total_area,
                //'square_kitchen' => $house->kitchen_area,
                'square_kitchen' => 0,
                'year_built' => $house->year_built,
                'bathrooms' => $house->bathrooms,
                'floor_all' => $house->floor_all,
                //1 - аренда. 2 - покупка
                'deal_type_id' => 2,
                'status_id' => $house->status_publication,
                'description' => $house->notesite,
                'coordinate_lat' => $house->coordinate_lat,
                'coordinate_long' => $house->coordinate_long,
                'sub_type_id' => $house->sub_type_id,
                'date' => $house->date_modified ? $house->date_modified : $house->date_added,
                'images' => $this->transformImagesToString($house->getImages()),
                'agents' => [
                    $house->agent1_id,
                    $house->agent2_id,
                    $house->agent3_id,
                ]
            ];
        }
        return $response;
    }
    private function transformAreas(array $areas)
    {
        $response = [];

        foreach($areas as $area) {
            $response[] = [
                'foreign_id' => $area['id'],
                //своя собственная таблица
                'realty_type_id' => 3,
                'price' => $area['price'],
                //скопировать таблицы из текущего сайта
                'district_id' => $area['region_kharkiv_admin_id'],
                'metro_id' => $area['metro_id'],
                'street' => $area->street,
                'number_building' => $area->number_building,
                //'street_name' => $area->street->name,
                'state_id' => $area->realty_state_id,
                'total_area' => $area->total_area,
                //1 - аренда. 2 - покупка
                'deal_type_id' => $area->deal_type_id,
                'status_id' => $area->status_publication,
                'description' => $area->notesite,
                'coordinate_lat' => $area->coordinate_lat,
                'coordinate_long' => $area->coordinate_long,
                'sub_type_id' => $area->sub_type_id,
                'date' => $area->date_modified ? $area->date_modified : $area->date_added,
                'images' => $this->transformImagesToString($area->getImages()),
                'agents' => [
                    $area->agent1_id,
                    $area->agent2_id,
                    $area->agent3_id,
                ]
            ];
        }
        return $response;
    }
    private function transformCommercials(array $commercials)
    {
        $response = [];

        foreach($commercials as $commercial) {
            $response[] = [
                'foreign_id' => $commercial['id'],
                //своя собственная таблица
                'realty_type_id' => 4,
                'price' => $commercial['price'],
                //скопировать таблицы из текущего сайта
                'district_id' => $commercial['region_kharkiv_admin_id'],
                'metro_id' => $commercial['metro_id'],
                'street' => $commercial->street,
                'number_building' => $commercial->number_office,
                //'street_name' => $commercial->street->name,
                'state_id' => $commercial->realty_state_id,
                'total_area' => $commercial->total_area,
                'square_living' => $commercial->floor_area,
                'square_kitchen' => $commercial->kitchen_area,
                'year_built' => $commercial->year_built,
                //1 - аренда. 2 - купить
                'deal_type_id' => $commercial->rent === 1 ? 1 : 2,
                'status_id' => $commercial->status_publication,
                'description' => $commercial->notesite,
                'coordinate_lat' => $commercial->coordinate_lat,
                'coordinate_long' => $commercial->coordinate_long,
                'sub_type_id' => $commercial->sub_type_id,
                'date' => $commercial->date_modified ? $commercial->date_modified : $commercial->date_added,
                'images' => $this->transformImagesToString($commercial->getImages()),
                'agents' => [
                    $commercial->agent1_id,
                    $commercial->agent2_id,
                    $commercial->agent3_id,
                ]
            ];
        }
        return $response;
    }
    private function transformBuildings(array $buildings)
    {
        $response = [];

        foreach($buildings as $building) {
            $response[] = [
                'foreign_id' => $building['id'],
                //своя собственная таблица
                'realty_type_id' => 2,
                'price' => $building['price'],
                //скопировать таблицы из текущего сайта
                'district_id' => $building['region_kharkiv_admin_id'],
                'metro_id' => $building['metro_id'],
                'rooms' => $building['count_room'],
                'street' => $building->street,
                'number_building' => $building->number_building,
                //'street_name' => $building->street->name,
                'state_id' => $building->realty_state_id,
                'total_area' => $building->total_area,
                'square_living' => $building->floor_area,
                'square_kitchen' => $building->kitchen_area,
                'year_built' => $building->year_built,
                //1 - аренда. 2 - купить
                'deal_type_id' => $building->deal_type_id,
                'status_id' => $building->status_publication,
                'description' => $building->notesite,
                'sub_type_id' => $building->sub_type_id,
                'bathrooms' => $building->bath,
                'floor' => $building->floor,
                'floor_all' => $building->floor_all,
                'layout' => in_array($building->layout, [9,10,11,12,13]) ? $building->layout : null,
                'wc_in_house' => $building->wc_id,
                'count_balcony' => $building->count_balcony,
                'count_balcony_glazed' => $building->count_balcony_glazed,
                'condit_id' => $building->condit_id,
                'lived_complex_id' => $building->lived_complex_id,
                'date' => $building->date_modified ? $building->date_modified : $building->date_added,
                'images' => $this->transformImagesToString($building->getImages()),
                'agents' => [
                    $building->agent1_id,
                    $building->agent2_id,
                    $building->agent3_id,
                ]
            ];
        }
        return $response;
    }

    public function actionAgents()
    {
        $agents = Agents::find()->where(['is_publish' => 1])->asArray()->all();
        
        foreach($agents as &$agent) {
            $numbersArray = explode(',',$agent['numbers']);

            $agentNumbers = [];
            //если есть элементы сохраняем, если нет сохраняем исходные данные.
            if($numbersArray[0]) {
                $agent['numbers'] = $numbersArray;
            } else {
                $agent['numbers'] = [$agent['numbers']];
            }
        }

        return json_encode($agents, 200);
    }

    public function actionComplexes()
    {
        $livedComplexes = LivedComplex::find()->asArray()->all();
        return json_encode($livedComplexes, 200);
    }

    private function getDataFromRent($limit, $page, $realtyTypeId, $typeObjectId)
    {
        $query = Rent::find()->where(['enabled' => 1, 'is_publish' => 1, 'type_object_id' => $typeObjectId]);
        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
        ]);

        $models = $query->offset($pages->offset)
            ->limit($limit)
            ->offset($page * $limit)
            ->all();

        return $this->transformRent($models, $realtyTypeId);
    }

    public function actionInfo($type = 'apartments', $page = 1)
    {
        $limit = 100;

        $realties = [];
        $status = 200;

        if($type === 'apartments') {
            $rentApartments = $this->getDataFromRent($limit, $page, 1, 6);

            $query = Apartment::find()->where(['enabled' => 1, 'is_publish' => 1]);

            $models = $query
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->all();
            $realties = $this->transformApartments($models);

            $realties = array_merge($realties,$rentApartments);

        } elseif($type === 'houses') {
            $rentHouses = $this->getDataFromRent($limit, $page, 1, 5);

            $query = House::find()->where(['enabled' => 1, 'is_publish' => 1]);

            $models = $query
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->all();
            $realties = $this->transformHouses($models);

            $realties = array_merge($realties,$rentHouses);

        } elseif($type === 'areas') {
            $query = Area::find()->where(['enabled' => 1, 'is_publish' => 1]);

            $models = $query
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->all();
            $realties = $this->transformAreas($models);
        } elseif($type === 'commercials') {
            $query = Commercial::find()->where(['enabled' => 1, 'is_publish' => 1]);

            $models = $query
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->all();
            $realties = $this->transformCommercials($models);
        } elseif($type === 'building') {
            $query = Building::find()->where(['enabled' => 1, 'is_publish' => 1]);

            $models = $query
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->all();

            $realties = $this->transformBuildings($models);
        } else {
            $status = 400;
        }

        return json_encode($realties, $status);

    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    //---------------- realty menu items ----------------------

    public function actionApartment()
    {
        $searchModel = new ApartmentSearch();
        $query = $searchModel->search(Yii::$app->request->queryParams);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => '6']);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        //fill searches values
        $values = Yii::$app->request->get('ApartmentSearch');
        $searchModel->attributes = $values;
        return $this->render('apartment', ['apartments' => $models, 'pages' => $pages, 'searchModel' => $searchModel]);
    }

    public function actionApartmentDetail($id)
    {
        $apartment = Apartment::findOne($id);
        return $this->render('apartmentDetail',['apartment' => $apartment]);
    }

    public function actionRent()
    {
        $searchModel = new RentSearch();
        $query = $searchModel->search(Yii::$app->request->queryParams);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => '6']);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        //fill searches values
        $values = Yii::$app->request->get('RentSearch');
        $searchModel->attributes = $values;
        return $this->render('rent', ['rents' => $models, 'pages' => $pages, 'searchModel' => $searchModel]);
    }

    public function actionRentDetail($id)
    {
        $rent = Rent::findOne($id);
        return $this->render('rentDetail',['rent' => $rent]);
    }

    public function actionBuilding()
    {
        $searchModel = new BuildingSearch();
        $query = $searchModel->search(Yii::$app->request->queryParams);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => '6']);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        //fill searches values
        $values = Yii::$app->request->get('BuildingSearch');
        $searchModel->attributes = $values;
        return $this->render('building', ['buildings' => $models, 'pages' => $pages, 'searchModel' => $searchModel]);
    }

    public function actionBuildingDetail($id)
    {
        $building = Building::findOne($id);
        return $this->render('buildingDetail',['building' => $building]);
    }

    public function actionHouse()
        {
            $searchModel = new HouseSearch();
            $query = $searchModel->search(Yii::$app->request->queryParams);
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => '6']);
            $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
            //fill searches values
            $values = Yii::$app->request->get('HouseSearch');
            $searchModel->attributes = $values;
            return $this->render('house', ['houses' => $models, 'pages' => $pages, 'searchModel' => $searchModel]);
        }

    public function actionHouseDetail($id)
        {
            $house = House::findOne($id);
            return $this->render('houseDetail',['house' => $house]);
        }

    public function actionArea()
        {
            $searchModel = new AreaSearch();
            $query = $searchModel->search(Yii::$app->request->queryParams);
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => '6']);
            $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
            //fill searches values
            $values = Yii::$app->request->get('AreaSearch');
            $searchModel->attributes = $values;
            return $this->render('area', ['areas' => $models, 'pages' => $pages, 'searchModel' => $searchModel]);
        }

    public function actionAreaDetail($id)
        {
            $area = Area::findOne($id);
            return $this->render('areaDetail',['area' => $area]);
        }

    public function actionCommercial()
        {
            $searchModel = new CommercialSearch();
            $query = $searchModel->search(Yii::$app->request->queryParams);
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => '6']);
            $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
            //fill searches values
            $values = Yii::$app->request->get('CommercialSearch');
            $searchModel->attributes = $values;
            return $this->render('commercial', ['commercials' => $models, 'pages' => $pages, 'searchModel' => $searchModel]);
        }

    public function actionCommercialDetail($id)
        {
            $commercial = Commercial::findOne($id);
            return $this->render('commercialDetail',['commercial' => $commercial]);
        }

    //---------------- other menu items--------------------
    public function actionCompanyHistory()
    {
        $history = CompanyInfo::findOne(['name' => 'history'])->data;
        return $this->render('history',['history' => $history]);
    }

    public function actionVacancy()
    {
        $vacancy = [];
        $info = CompanyInfo::findAll(['name' => 'vacancy']);
        foreach ($info as $key) {
            $vacancy[] = $key->data;
        }
        return $this->render('vacancy',['vacancy' => $vacancy]);
    }

    public function actionCarier()
    {
        $carier = CompanyInfo::findOne(['name' => 'carier'])->data;
        return $this->render('carier',['carier' => $carier]);
    }

    public function actionBestRieltors()
    {
        $best_rieltors = CompanyInfo::findOne(['name' => 'best_rieltors'])->data;
        return $this->render('best_rieltors',['best_rieltors' => $best_rieltors]);
    }

    public function actionReview()
    {
        $review = Review::find()->where(['status' => '1'])->orderBy('date','asc')->all();
        return $this->render('review',['review' => $review]);
    }

    public function actionContacts()
    {
        return $this->render('contacts');
    }

    public function actionNews()
    {
        $query = News::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => '2']);
        $news = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        
        return $this->render('news', ['news' => $news, 'pages' => $pages]);
    }

    public function actionArticle()
    {
        $query = Article::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => '2']);
        $article = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        
        return $this->render('article', ['article' => $article, 'pages' => $pages]);
    }

    public function actionBuy()
    {
        $apartments = $this->getRandomApartments();
        $houses = $this->getRandomHouses();
        $areas = $this->getRandomAreas();
        $commercials = $this->getRandomCommercials();
        return $this->render('buy', ['apartments' => $apartments, 'houses' => $houses, 'areas' => $areas, 'commercials' => $commercials]);
    }

    public  function getRandomApartments()
    {
        $ids = [];
        $model = Addsite::find()->select('idbase')->where(['base' => 'apartment'])->all();
        foreach ($model as $item)
        {
            array_push($ids, $item->idbase);
        }
        shuffle($ids);
        $apartments = Apartment::find()->andFilterWhere(['in', 'id', [$ids[0], $ids[1], $ids[3]]])->all();
        return $apartments;
    }

    public  function getRandomHouses()
    {
        $ids = [];
        $model = Addsite::find()->select('idbase')->where(['base' => 'house'])->all();
        foreach ($model as $item)
        {
            array_push($ids, $item->idbase);
        }
        shuffle($ids);
        $houses = House::find()->andFilterWhere(['in', 'id', [$ids[0], $ids[1], $ids[3]]])->all();
        return $houses;
    }

    public  function getRandomAreas()
    {
        $ids = [];
        $model = Addsite::find()->select('idbase')->where(['base' => 'area'])->all();
        foreach ($model as $item)
        {
            array_push($ids, $item->idbase);
        }
        shuffle($ids);
        $areas = Area::find()->andFilterWhere(['in', 'id', [$ids[0], $ids[1], $ids[3]]])->all();
        return $areas;
    }

    public  function getRandomCommercials()
    {
        $ids = [];
        $model = Addsite::find()->select('idbase')->where(['base' => 'commercial'])->all();
        foreach ($model as $item)
        {
            array_push($ids, $item->idbase);
        }
        shuffle($ids);
        $commercials = Commercial::find()->andFilterWhere(['in', 'id', [$ids[0], $ids[1], $ids[3]]])->all();
        return $commercials;
    }

    public  function getRandomRents()
    {
        $ids = [];
        $model = Addsite::find()->select('idbase')->where(['base' => 'rent'])->all();
        foreach ($model as $item)
        {
            array_push($ids, $item->idbase);
        }
        shuffle($ids);
        $rents = Rent::find()->andFilterWhere(['in', 'id', [$ids[0], $ids[1], $ids[3]]])->all();
        return $rents;
    }

    public function actionToRent()
    {
        $rents = $this->getRandomRents();
        return $this->render('to-rent', ['rents' => $rents]);
    }

    public function actionValuation()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', Yii::t('yii', 'Thank you for contacting us. We will respond to you as soon as possible.'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('yii', 'There was an error sending your message.'));
            }

            return $this->refresh();
        } else {
            return $this->render('valuation', [
                'model' => $model,
            ]);
        }

        return $this->render('valuation');
    }

    public function actionForOwners()
    {
        return $this->render('for-owners');
    }

    public function actionMail()
    {

        //$fsc = fsockopen("ssl://smtp.gmail.com", 465, $errno, $errstr, 15);
        $fsc = fsockopen("mail.metrag.dev.itgo-solutions.com", 465, $errno, $errstr, 15);
        //$fsc = fsockopen("tls://smtp.gmail.com", 587, $errno, $errstr, 15);
        if (!$fsc) {
            echo "$errstr ($errno)<br />\n";
        } else {
            echo "connected";
            fclose($fsc);
        }
        echo '<br>end<br>';
        die;

        $email = 'metragkharkiv.mail@gmail.com';
        $message = 'test mail message';
        $result = mail($email, 'My Subject', $message);

        return $this->render('mail', ['result' => $result]);
    }

    public function actionNewMail()
    {
        // For some users works using the gethostbyname function
        //$smtp_host_ip = gethostbyname('smtp.gmail.com');
        // But for others only the smtp address
        $smtp_host_ip = 'smtp.gmail.com';

        $transport = \Swift_SmtpTransport::newInstance($smtp_host_ip, 465, 'ssl')->setUsername('metragkharkiv.mail@gmail.com')->setPassword('50WpQfZu');
        //$transport = \Swift_SmtpTransport::newInstance($smtp_host_ip, 587, 'tls')->setUsername('metragkharkiv.mail@gmail.com')->setPassword('50WpQfZu');
        //var_dump($transport);
        //die;
        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance()
            ->setFrom(array("john@doe.com" => 'John Doe'))
            ->setTo(array("skovorodkinsergey86@gmail.com" => 'sergey'));
        $message->setBody('<h3>Contact message</h3>', 'text/html');

        $result = $mailer->send($message);
        return $this->render('newmail', ['result' => $result]);
    }

}
