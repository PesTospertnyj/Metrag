<?php
namespace frontend\controllers;

use common\models\Area;
use common\models\Building;
use common\models\Commercial;
use common\models\House;
use common\models\Rent;
use Yii;
use yii\base\InvalidParamException;
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
        $query = Addsite::find()->where(['base' => 'apartment'])->orderBy(['id' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => '6']);
        $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();

        $apartments = [];
        foreach ($models as $item) {
                        $apartments[$item['idbase']] = Apartment::find()
                                                    ->where(['id' => $item['idbase']])
                                                    ->one();
                        }

        return $this->render('apartment', ['apartments' => $apartments, 'pages' => $pages]);
    }

    public function actionApartmentDetail($id)
    {
        $apartment = Apartment::findOne($id);
        return $this->render('apartmentDetail',['apartment' => $apartment]);
    }

    public function actionRent()
    {
        $query = Addsite::find()->where(['base' => 'rent']);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => '6']);
        $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();

        $rents = [];
        foreach ($models as $item) {
                        $rents[$item['idbase']] = Rent::find()
                                                    ->where(['id' => $item['idbase']])
                                                    ->one();
                        }

        return $this->render('rent', ['rents' => $rents, 'pages' => $pages]);
    }

    public function actionRentDetail($id)
    {
        $rent = Rent::findOne($id);
        return $this->render('rentDetail',['rent' => $rent]);
    }

    public function actionBuilding()
    {
        $query = Addsite::find()->where(['base' => 'building']);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => '6']);
        $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();

        $buildings = [];
        foreach ($models as $item) {
                        $buildings[$item['idbase']] = Building::find()
                                                    ->where(['id' => $item['idbase']])
                                                    ->one();
                        }

        return $this->render('building', ['buildings' => $buildings, 'pages' => $pages]);
    }

    public function actionBuildingDetail($id)
    {
        $building = Building::findOne($id);
        return $this->render('buildingDetail',['building' => $building]);
    }

    public function actionHouse()
        {
            $query = Addsite::find()->where(['base' => 'house']);
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => '6']);
            $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

            $houses = [];
            foreach ($models as $item) {
                            $houses[$item['idbase']] = House::find()
                                                        ->where(['id' => $item['idbase']])
                                                        ->one();
                            }

            return $this->render('house', ['houses' => $houses, 'pages' => $pages]);
        }

    public function actionHouseDetail($id)
        {
            $house = House::findOne($id);
            return $this->render('houseDetail',['house' => $house]);
        }

    public function actionArea()
        {
            $query = Addsite::find()->where(['base' => 'area']);
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => '6']);
            $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

            $areas = [];
            foreach ($models as $item) {
                            $areas[$item['idbase']] = Area::find()
                                                        ->where(['id' => $item['idbase']])
                                                        ->one();
                            }

            return $this->render('area', ['areas' => $areas, 'pages' => $pages]);
        }

    public function actionAreaDetail($id)
        {
            $area = Area::findOne($id);
            return $this->render('areaDetail',['area' => $area]);
        }

    public function actionCommercial()
        {
            $query = Addsite::find()->where(['base' => 'commercial']);
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => '6']);
            $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

            $commercials = [];
            foreach ($models as $item) {
                            $commercials[$item['idbase']] = Commercial::find()
                                                        ->where(['id' => $item['idbase']])
                                                        ->one();
                            }

            return $this->render('commercial', ['commercials' => $commercials, 'pages' => $pages]);
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
        return $this->render('buy');   
    }

}
