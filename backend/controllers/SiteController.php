<?php
namespace backend\controllers;

use backend\models\ApartmentFind;
use backend\models\AreaFind;
use backend\models\BuildingFind;
use backend\models\CommercialFind;
use backend\models\HouseFind;
use backend\models\MainSearch;
use backend\models\RentFind;
use common\models\Apartment;
use Yii;
use yii\base\Exception;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

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
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new MainSearch();

        //if ($model->validate()) {
        if (Yii::$app->request->post('MainSearch')) {
            $data = Yii::$app->request->post('MainSearch');
            $model->type_realty = $data['type_realty'];
            $model->id = $data['id'];
            $model->phone = $data['phone'];

            try {
                switch ($model->type_realty) {
                    case 'apartment': {
                        $searchModel = new ApartmentFind();
                        $searchModel->id = $model->id;
                        $searchModel->phone = $model->phone;
                        $this->redirect('/admin/apartment/searchresult?ApartmentFind%5Bphone%5D=' . $model->phone . '&ApartmentFind%5Bid%5D=' . $model->id);
                        break;
                    }
                    case 'rent': {
                        $searchModel = new RentFind();
                        $searchModel->id = $model->id;
                        $searchModel->phone = $model->phone;
                        $this->redirect('/admin/rent/searchresult?RentFind%5Bphone%5D=' . $model->phone . '&RentFind%5Bid%5D=' . $model->id);
                        break;
                    }
                    case 'building': {
                        $searchModel = new BuildingFind();
                        $searchModel->id = $model->id;
                        $searchModel->phone = $model->phone;
                        $this->redirect('/admin/building/searchresult?BuildingFind%5Bphone%5D=' . $model->phone . '&BuildingFind%5Bid%5D=' . $model->id);
                        break;
                    }
                    case 'house': {
                        $searchModel = new HouseFind();
                        $searchModel->id = $model->id;
                        $searchModel->phone = $model->phone;
                        $this->redirect('/admin/house/searchresult?HouseFind%5Bphone%5D=' . $model->phone . '&HouseFind%5Bid%5D=' . $model->id);
                        break;
                    }
                    case 'area': {
                        $searchModel = new AreaFind();
                        $searchModel->id = $model->id;
                        $searchModel->phone = $model->phone;
                        $this->redirect('/admin/area/searchresult?AreaFind%5Bphone%5D=' . $model->phone . '&AreaFind%5Bid%5D=' . $model->id);
                        break;
                    }
                    case 'commercial': {
                        $searchModel = new CommercialFind();
                        $searchModel->id = $model->id;
                        $searchModel->phone = $model->phone;
                        $this->redirect('/admin/commercial/searchresult?CommercialFind%5Bphone%5D=' . $model->phone . '&CommercialFind%5Bid%5D=' . $model->id);
                        break;
                    }
                }
            }
            catch(Exception $ex){
                    echo '!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!';
                    echo $ex->getMessage();
                }

            } else {
            return $this->render('index', ['model' => $model]);
        }

    }

    public function searchModelSelect($type_realty){
        switch ($type_realty){
            case 'apartment':{
                $searchModel = new ApartmentFind();
                break;
            }
            case 'rent':{
                break;
            }
            case 'building':{
                break;
            }
            case 'house':{
                break;
            }
            case 'area':{
                break;
            }
            case 'commercial':{
                break;
            }
            default : {
                $searchModel = null;
            }
        }
        return $searchModel;
    }
    /**
     * Login action.
     *
     * @return string
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
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
