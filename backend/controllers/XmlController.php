<?php

namespace backend\controllers;

use backend\models\Locality;
use backend\models\Metro;
use backend\models\Region;
use backend\models\RegionKharkivAdmin;
use backend\models\Street;
use backend\models\TypeObject;
use backend\models\TypeRealty;
use backend\models\WallMaterial;
use backend\models\Wc;
use backend\models\XmlData;
use common\models\Apartment;
use common\models\Area;
use common\models\Building;
use common\models\Commercial;
use common\models\House;
use common\models\Rent;
use Yii;
use backend\models\Xml;
use backend\models\XmlSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use rico\yii2images\controllers\ImagesController;
use rico\yii2images\models\Image;

use yii\data\Pagination;
/**
 * XmlController implements the CRUD actions for Xml model.
 */
class XmlController extends Controller
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
     * Lists all Xml models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new XmlSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Xml model.
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
     * Creates a new Xml model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Xml();
        $timestamp = XmlData::getTimestamp();
        return $this->render('create', [
                'model' => $model, 'timestamp' => $timestamp,
            ]);

    }

    /**
     * Updates an existing Xml model.
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
     * Deletes an existing Xml model.
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
     * Finds the Xml model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Xml the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Xml::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function createBesplatkaXml(){
        /*besplatka*/
        $data = [];
        $realities = Xml::find()->where(['besplatka' => 1])->all();
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><realities></realities>');

        foreach ($realities as $elem){
            $arrErrors = [];
            $photos_arr = [];
            /*область*/
            $state = 'Харьковская';
            /*свой идентификатор - названиеКатегории_айди*/
            $local_reality_id = $elem['type']. '_' .$elem['type_id'];
            /*категория*/
            switch ($elem['type']){
                /*case 'rent':{
                    //Аренда дома или квартиры
                    $rent_type = $this->engine->db->query("SELECT * FROM " . DB_PREF . "rent WHERE rent_id = " . $elem['type_id'])->row;
                    if ($rent_type['type_object_id'] == 5){
                        $cat_str = "Недвижимость/Аренда домов";
                    }
                    if ($rent_type['type_object_id'] == 6){
                        switch ((int)$rent_type['count_room']){
                            case 1: $cat_str = "Недвижимость/Аренда квартир/1-комнатные"; break;
                            case 2: $cat_str = "Недвижимость/Аренда квартир/2-комнатные"; break;
                            case 3: $cat_str = "Недвижимость/Аренда квартир/3-комнатные"; break;
                            case 4: $cat_str = "Недвижимость/Аренда квартир/4-комнатные"; break;
                            case 5: $cat_str = "Недвижимость/Аренда квартир/5-комнатные"; break;
                            default: $cat_str = "Недвижимость/Аренда квартир/6+ комнат";
                        }
                    }
                    $descr_str = $rent_type['notesite'];
                    $phone = $rent_type['phone'];
                    //массив с фотками
                    $realty = $this->engine->db->query("SELECT * FROM " . DB_PREF . "type_object WHERE type_object_id = " . $rent_type['type_object_id'])->row;
                    $photos_arr = $this->engine->db->query("SELECT * FROM " . DB_PREF . "photo WHERE type_realty_id = " . $realty['type_realty_id'] . " AND object_id = " . $elem['type_id'])->rows;
                    //зануляем, чтобы с прошлой итерации лишенего не пришло
                    $chars = [];
                    $chars['obshchaya-ploshchad'] = '';//не предусмотрено админкой
                    if ($rent_type['city_or_region'] == 0){
                        $name_raion = $this->engine->db->query("SELECT * FROM " . DB_PREF . "region_kharkiv_admin WHERE region_kharkiv_admin_id = " . $rent_type['region_kharkiv_admin_id'])->row;
                        $chars['raion'] = $name_raion['name'] . " р-н";
                    }
                    $chars['cena'] = $rent_type['price'];
                    $chars['tip-arendy'] = 'Долгосрочная аренда';//в админке нет, уточнить у клиента
                    $chars['tip-predlozheniya'] = 'От посредника';
                    $chars['currency'] = 'Гривна';
                    //для логгирования ошибок
                    $error_pointer['type'] = $rent_type['type_object_id'];
                    $error_pointer['id'] = $rent_type['rent_id'];
                    break;
                }*/
                case 'apartment':{
                    /*квартиры*/
                    $apartment_type = Apartment::findOne(['id' => $elem['type_id']]);
                    if(!$apartment_type) break;
                    switch ((int)$apartment_type->count_room){
                        case 1: $cat_str = "Недвижимость/Продажа квартир/1-комнатные"; break;
                        case 2: $cat_str = "Недвижимость/Продажа квартир/2-комнатные"; break;
                        case 3: $cat_str = "Недвижимость/Продажа квартир/3-комнатные"; break;
                        case 4: $cat_str = "Недвижимость/Продажа квартир/4-комнатные"; break;
                        case 5: $cat_str = "Недвижимость/Продажа квартир/5-комнатные"; break;
                        default: $cat_str = "Недвижимость/Продажа квартир/6+ комнат";
                    }
                    $title = 'Продам квартиру ' . (int)$apartment_type->total_area. ' кв. м.';
                    $descr_str = $apartment_type->notesite;
                    $phone = $apartment_type->phone;
                    /*массив с фотками*/
                    $images = $apartment_type->getImages();
                    foreach($images as $img) {
                        if($img) array_push($photos_arr, Url::base(true).'/'.$img->getPathToOrigin());
                    }
                    $chars = [];
                    $chars['obshchaya-ploshchad'] = (int)$apartment_type->total_area;
                    if ($apartment_type->city_or_region == 0){
                        $city = 'Харьков';
                        $name_raion = RegionKharkivAdmin::findOne(['region_kharkiv_admin_id' => $apartment_type->region_kharkiv_admin_id]);
                        $chars['raion'] = $name_raion->name . " р-н";
                    }else{
                        $city = Region::findOne(['region_id' => $apartment_type->region_id])->name;
                    }
                    $chars['cena'] = (int)$apartment_type->price;
                    $chars['tip-kvartir'] = 'Вторичный рынок';
                    $chars['tip-predlozheniya'] = 'От посредника';
                    $chars['currency'] = 'Доллар';
                    $error_pointer['type'] = $apartment_type->type_object_id;
                    $error_pointer['id'] = $apartment_type->id;
                    break;
                }
                case 'building':{
                    /*новостройки - делим между обычными домами и квартирами (раздела новостоек нет на бесплатке*/
                    $new_type = Building::findOne(['id' => $elem['type_id']]);
                    if(!$new_type) break;
                    if ($new_type->type_object_id == 3){
                        $cat_str = "Недвижимость/Продажа домов";
                        $title = 'Продам дом ' . (int)$new_type->total_area. ' кв. м.';
                    }
                    if ($new_type->type_object_id == 4){
                        switch ((int)$new_type->count_room){
                            case 1: $cat_str = "Недвижимость/Продажа квартир/1-комнатные"; break;
                            case 2: $cat_str = "Недвижимость/Продажа квартир/2-комнатные"; break;
                            case 3: $cat_str = "Недвижимость/Продажа квартир/3-комнатные"; break;
                            case 4: $cat_str = "Недвижимость/Продажа квартир/4-комнатные"; break;
                            case 5: $cat_str = "Недвижимость/Продажа квартир/5-комнатные"; break;
                            default: $cat_str = "Недвижимость/Продажа квартир/6+ комнат";
                        }
                        $title = 'Продам квартиру ' . (int)$new_type->total_area. ' кв. м.';
                    }
                    $descr_str = $new_type->notesite;
                    $phone = $new_type->phone;
                    /*массив с фотками*/
                    $images = $new_type->getImages();
                    foreach($images as $img) {
                        if($img) array_push($photos_arr, Url::base(true).'/'.$img->getPathToOrigin());
                    }$chars = [];
                    $chars['obshchaya-ploshchad'] = (int)$new_type->total_area;
                    if ($new_type->city_or_region == 0){
                        $city = 'Харьков';
                        $name_raion = RegionKharkivAdmin::findOne(['region_kharkiv_admin_id' => $new_type->region_kharkiv_admin_id]);
                        $chars['raion'] = $name_raion->name . " р-н";
                    }else{
                        $city = Region::findOne(['region_id' => $new_type->region_id])->name;
                    }
                    $chars['cena'] = (int)$new_type->price;
                    if ($new_type->type_object_id == 3){
                        $chars['tip-domov'] = 'Дом в городе';
                    }
                    if ($new_type->type_object_id == 4){
                        $chars['tip-kvartir'] = 'Новостройки';
                    }
                    $chars['tip-predlozheniya'] = 'От посредника';
                    $chars['currency'] = 'Доллар';
                    $error_pointer['type'] = $new_type->type_object_id;
                    $error_pointer['id'] = $new_type->id;
                    break;
                }
                case 'house':{
                    /*дома и дачи*/
                    $house_type = House::findOne(['id' => $elem['type_id']]);
                    if(!$house_type) break;
                    if ($house_type->type_object_id == 7){
                        $cat_str = "Недвижимость/Продажа домов";
                        $title = 'Продам дом ' . (int)$house_type->total_area_house. ' кв. м.';
                    }
                    if ($house_type['type_object_id'] == 8){
                        $cat_str = "Недвижимость/Продажа дач";
                        $title = 'Продам дачу ' . (int)$house_type->total_area_house . ' кв. м.';
                    }
                    $descr_str = $house_type->notesite;
                    $phone = $house_type->phone;
                    /*массив с фотками*/
                    $images = $house_type->getImages();
                    foreach($images as $img) {
                        if($img) array_push($photos_arr, Url::base(true).'/'.$img->getPathToOrigin());
                    }
                    $chars = [];
                    $chars['obshchaya-ploshchad'] = (int)$house_type->total_area_house;
                    if ($house_type->city_or_region == 0){
                        $city = 'Харьков';
                        $name_raion = RegionKharkivAdmin::findOne(['region_kharkiv_admin_id' => $house_type->region_kharkiv_admin_id]);
                        $chars['raion'] = $name_raion->name . " р-н";
                    }else{
                        $city = Region::findOne(['region_id' => $house_type->region_id])->name;
                    }
                    $chars['cena'] = (int)$house_type->price;
                    if ($house_type->type_object_id == 7) {
                        $chars['tip-domov'] = 'Дом в городе';
                    }
                    $chars['tip-predlozheniya'] = 'От посредника';
                    $chars['currency'] = 'Доллар';
                    $error_pointer['type'] = $house_type->type_object_id;
                    $error_pointer['id'] = $house_type->id;
                    break;
                }
                case 'area':{
                    /*земельные участки - тут надо будет доделать, ибо на бесплатке они еще делятся по назвачению*/
                    $area_type = Area::findOne(['id' => $elem['type_id']]);
                    if(!$area_type) break;
                    if ($area_type->type_object_id == 9){
                        $cat_str = "Недвижимость/Продажа земельных участков/Под застройку";
                    }
                    $title = 'Продам земельный участок ' . (int)$area_type->total_area. ' кв. м.';
                    $descr_str = $area_type->notesite;
                    $phone = $area_type->phone;
                    /*массив с фотками*/
                    $images = $area_type->getImages();
                    foreach($images as $img) {
                        if($img) array_push($photos_arr, Url::base(true).'/'.$img->getPathToOrigin());
                    }$chars = [];
                    $chars['obshchaya-ploshchad'] = (int)$area_type->total_area;
                    if ($area_type->city_or_region == 0){
                        $city = 'Харьков';
                        $name_raion = RegionKharkivAdmin::findOne(['region_kharkiv_admin_id' => $area_type->region_kharkiv_admin_id]);
                        $chars['raion'] = $name_raion->name . " р-н";
                    }else{
                        $city = Region::findOne(['region_id' => $area_type->region_id])->name;
                    }
                    $chars['cena'] = (int)$area_type->price;
                    $chars['tip-predlozheniya'] = 'От посредника';
                    $chars['currency'] = 'Доллар';
                    $error_pointer['type'] = $area_type->type_object_id;
                    $error_pointer['id'] = $area_type->id;
                    break;
                }
                case 'commercial':{
                    $commercial_type = Commercial::findOne(['id' => $elem['type_id']]);
                    if(!$commercial_type) break;
                    if ($commercial_type->type_object_id == 10){
                        $cat_str = "Недвижимость/Продажа гаражей и автомест";
                        $title = 'Продам гараж';
                    }
                    if ($commercial_type->type_object_id == 11){
                        $cat_str = "Недвижимость/Продажа коммерческой недвижимости/Офисные помещения";
                        $title = 'Продам офис ' . (int)$commercial_type->total_area. ' кв. м.';
                    }
                    $descr_str = $commercial_type->notesite;
                    $phone = $commercial_type->phone;
                    /*массив с фотками*/
                    $images = $commercial_type->getImages();
                    foreach($images as $img) {
                        if($img) array_push($photos_arr, Url::base(true).'/'.$img->getPathToOrigin());
                    }
                    $chars = [];
                    if ($commercial_type->type_object_id == 11){
                        $chars['obshchaya-ploshchad'] = (int)$commercial_type->total_area;
                    }
                    if ($commercial_type->city_or_region == 0){
                        $city = 'Харьков';
                        $name_raion = RegionKharkivAdmin::findOne(['region_kharkiv_admin_id' => $commercial_type->region_kharkiv_admin_id]);
                        $chars['raion'] = $name_raion->name . " р-н";
                    }else{
                        $city = Region::findOne(['region_id' => $commercial_type->region_id])->name;
                    }
                    $chars['cena'] = (int)$commercial_type->price;
                    $chars['tip-predlozheniya'] = 'От посредника';
                    $chars['currency'] = 'Доллар';
                    $error_pointer['type'] = $commercial_type->type_object_id;
                    $error_pointer['id'] = $commercial_type->id;
                    break;
                }
            }

            /*ищем название категории через 2 таблицы*/
            if (isset($error_pointer['type']) && !empty($error_pointer['type'])){
                $type_real = TypeObject::findOne(['type_object_id' => $error_pointer['type']]);
                $category = TypeRealty::findOne(['type_realty_id' => $type_real->type_realty_id]);
            }
            $error_id_link = "<a href=\"".Url::base(true)."/".$elem['type']. "/update?id=".$elem['type_id']."\" target=\"_blank\">" .$error_pointer['id'] . "</a>";
            /*выносим и логгируем ошибки*/
            if (empty($city)){
                $arrErrors[] = 'Категория: ' . $category->name. ', id обьявления: ' . $error_id_link . ' Ошибка в обработке города(Бесплатка)';
            }
            if (!isset($cat_str) || empty($cat_str)) {
                $arrErrors[] = 'Категория: ' . $category->name . ', id обьявления: ' . $error_id_link . ' Ошибка в обработке категории(Бесплатка)';
            }
            if (!isset($title) || empty($title)){
                $arrErrors[] = 'Категория: ' . $category->name . ', id обьявления: ' . $error_id_link . ' Ошибка в обработке заголовка(Бесплатка)';
            }
            if (!isset($descr_str) || empty($descr_str)){
                $arrErrors[] = 'Категория: ' . $category->name . ', id обьявления: ' . $error_id_link . ' Ошибка: отсутствует описание(Бесплатка)';
            }
            if ((strlen($descr_str) < 16 && strlen($descr_str) > 0) || strlen($descr_str) > 2000){
                $arrErrors[] = 'Категория: ' . $category->name . ', id обьявления: ' . $error_id_link . ' Ошибка: описание должно быть длинной от 16 до 2000 символов(Бесплатка)';
            }
            if (!isset($phone) || empty($phone)){
                $arrErrors[] = 'Категория: ' . $category->name . ', id обьявления: ' . $error_id_link . ' Ошибка в обработке телефона(ов)(Бесплатка)';
            }
            foreach ($chars as $key=>$val){
                if (empty($val)){
                    $arrErrors[] = 'Категория: ' . $category->name . ', id обьявления: ' . $error_id_link . ' Ошибка в характеристике: ' . $key.'(Бесплатка)';
                }
            }
            if (empty($arrErrors)) {
                /*все хорошо, формируем дальше*/
                $reality = $xml->addChild('reality');
                $reality->addChild('state', $state);
                $reality->addChild('local_reality_id', $local_reality_id);
                $reality->addChild('city', $city);
                $reality->addChild('category', $cat_str);
                $reality->addChild('title', $title);
                $reality->addChild('description', $descr_str);
                $reality->addChild('telephone', $phone);
                $photos = $reality->addChild('photos_urls');
                /*без фоток - тег оставляем пустым*/
                if (isset($photos_arr) && !empty($photos_arr)){
                    $max_photo = 5;
                    $image_hash = '';
                    foreach ($photos_arr as $photo){
                        if ($max_photo > 0){
                            //$image_hash .= 'http://' . $_SERVER['SERVER_NAME'] . $photo['path'];
                            $image_hash .= $photo;
                            $photos->addChild('loc', $photo);
                            $max_photo--;
                        }
                    }
                    $image_hash = md5($image_hash);
                }
                /*характеристики у каждого типа обьявлений отличаются*/
                $char = $reality->addChild('characteristics');
                foreach ($chars as $key=>$val){
                    $char->addChild($key, $val);
                }
                $reality->addChild('hash', md5($descr_str));
                $reality->addChild('image_hash', $image_hash);
                $paid = $reality->addChild('paid_services');
                $paid->addChild('top');
                $paid->addChild('type');
                $paid->addChild('attention');
                $paid->addChild('original_text');
            }else{
                $data['errors'][] = $arrErrors;
            }
        }
        /*заливаем все в XML, и сообщение об успешной записи в админку*/
        if (file_put_contents('xmls/besplatka.xml', $xml->asXML())){
            $data['xml_success'][] = "Файл XML для бесплатки успешно перезаписан";
        }else{
            $data['xml_success'][] = "В результате перезаписи XML файла бесплатки произошла ошибка. Пожалуйста сделайте скриншот и обратитесь к разработчикам.";
        }
        /*end besplatka*/
        return $data;
        //var_dump($data);
    }

    public function createEstXml(){
        /*est*/
        $realty_feed = Xml::find()->where(['est' => 1])->all();
        $est = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><realty-feed></realty-feed>');
        $est->addAttribute('xmlns', 'http://webmaster.yandex.ru/schemas/feed/realty/2010-06');
        $est->addChild('generation-date', date(DATE_ATOM));

        foreach ($realty_feed as $elem){
            $arrErrors = [];
            $photos_arr = [];
            $xml_data = [];
            $xml_data['local_reality_id'] = $elem['type']. '_' .$elem['type_id'];
            switch ($elem['type']){
                case 'apartment':{
                    /*квартиры*/
                    $apartment_type = Apartment::findOne(['id' => $elem['type_id']]);
                    if(!$apartment_type) break;
                    $xml_data['type'] = "продажа";
                    $xml_data['property_type'] = 'жилая';
                    $xml_data['category_obj'] = "квартира";
                    $xml_data['creation_date'] = $apartment_type->date_added;
                    $xml_data['last_update_date'] = $apartment_type->date_modified;
                    if($apartment_type->metro_id != 0){
                        $xml_data['metro_name'] = Metro::findOne(['metro_id' => $apartment_type->metro_id])->name;
                    }
                    $xml_data['currency'] = 'USD';
                    $xml_data['area_value'] = $apartment_type->total_area;
                    $xml_data['area_unit'] = "кв. м";
                    $xml_data['living_space_value'] = $apartment_type->floor_area;
                    $xml_data['living_space_unit'] = "кв. м";
                    $xml_data['kitchen_space_value'] = $apartment_type->kitchen_area;
                    $xml_data['kitchen_space_unit'] = "кв. м";
                    $xml_data['rooms'] = $apartment_type->count_room;
                    $xml_data['floor'] = $apartment_type->floor;
                    switch ($apartment_type->layout_id) {
                        case '13':
                            $xml_data['studio'] = "true";
                            break;
                        case '11':
                            $xml_data['open_plan'] = "true";
                            break;
                        case '12':
                            $xml_data['rooms_type'] = "смежные";
                            break;
                        case '9':
                            $xml_data['rooms_type'] = "раздельные";
                            break;
                    }
                    if($apartment_type['count_balcony'] == 1)
                        $xml_data['balcony'] = "балкон";
                    if($apartment_type['count_balcony'] > 1)
                        $xml_data['balcony'] = $apartment_type['count_balcony']." балкона";
                    $xml_data['bathroom_unit'] = Wc::findOne(['wc_id' => $apartment_type->wc_id])->name;
                    if($apartment_type->phone_line == 1)
                        $xml_data['phone_line'] = "true";
                    else
                        $xml_data['phone_line'] = "false";
                    $xml_data['floors_total'] = $apartment_type->floor_all;
                    $xml_data['building_type'] = WallMaterial::findOne(['wall_material_id' => $apartment_type->wall_material_id])->name;
                    $xml_data['apartment'] = $apartment_type->number_apartment;

                    $error_pointer['type'] = $apartment_type->type_object_id;
                    $error_pointer['id'] = $apartment_type->id;

                    $xml_data['phonelist'] = explode(",", $apartment_type->phone);
                    $xml_data['price_value'] = $apartment_type->price;
                    if ($apartment_type->city_or_region == 0){
                        $xml_data['locality_name'] = 'Харьков';
                        if(isset($apartment_type->region_kharkiv_admin_id) && $apartment_type->region_kharkiv_admin_id != 0){
                            $xml_data['sub_locality_name'] = RegionKharkivAdmin::findOne(['region_kharkiv_admin_id' => region_kharkiv_admin_id])->name." район";
                        }
                    }else{
                        $regName = Region::findOne(['region_id' => $apartment_type->region_id])->name;
                        $locality_name = Locality::findOne(['locality_id' => $apartment_type->locality_id])->name;
                        $pattern = '/\(.+\)/i';
                        $xml_data['locality_name'] = preg_replace($pattern, "",$locality_name);
                        $xml_data['district'] = $regName;
                    }
                    $xml_data['address'] = Street::findOne(['street_id' => $apartment_type->street_id])->name;
                    //TODO сделать фильтр для улица, проспект итп!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                    if(isset($apartment_type->number_building)){
                        $xml_data['address'] .= ", ";
                        $xml_data['address'] .= $apartment_type->number_building;
                        $xml_data['address'] = trim($xml_data['address']);
                        if(isset($apartment_type->corps)){
                            $xml_data['address'] .= '/'.$apartment_type->corps;
                            trim($xml_data['address']);
                        }
                    }
                    $xml_data['description'] = $apartment_type->notesite;
                    $images = $apartment_type->getImages();
                    foreach($images as $img) {
                        if($img) array_push($photos_arr, Url::base(true).'/'.$img->getPathToOrigin());
                    }
                    break;
                }
                case 'building':{
                    /*новостройки*/
                    $new_type = Building::findOne(['id' => $elem['type_id']]);
                    if(!$new_type) break;
                    $xml_data['type'] = "продажа";
                    $xml_data['property_type'] = 'жилая';
                    if ($new_type->type_object_id == 3){
                        $xml_data['category_obj'] = "дом";
                    }
                    if ($new_type->type_object_id == 4){
                        $xml_data['category_obj'] = "квартира";
                    }
                    $xml_data['creation_date'] = $new_type->date_added;
                    $xml_data['last_update_date'] = $new_type->date_modified;
                    if($new_type->metro_id != 0){
                        $xml_data['metro_name'] = Metro::findOne(['metro_id' => $new_type->metro_id])->name;
                    }
                    $xml_data['currency'] = 'USD';
                    $xml_data['area_value'] = $new_type->total_area;
                    $xml_data['area_unit'] = "кв. м";
                    $xml_data['living_space_value'] = $new_type->floor_area;
                    $xml_data['living_space_unit'] = "кв. м";
                    $xml_data['kitchen_space_value'] = $new_type->kitchen_area;
                    $xml_data['kitchen_space_unit'] = "кв. м";
                    $xml_data['rooms'] = $new_type->count_room;
                    $xml_data['floor'] = $new_type->floor;
                    switch ($new_type->layout_id) {
                        case '13':
                            $xml_data['studio'] = "true";
                            break;
                        case '11':
                            $xml_data['open_plan'] = "true";
                            break;
                        case '12':
                            $xml_data['rooms_type'] = "смежные";
                            break;
                        case '9':
                            $xml_data['rooms_type'] = "раздельные";
                            break;
                    }
                    if($new_type->count_balcony == 1)
                        $xml_data['balcony'] = "балкон";
                    if($new_type->count_balcony > 1)
                        $xml_data['balcony'] = $new_type->count_balcony." балкона";
                    $xml_data['bathroom_unit'] = Wc::findOne(['wc_id' => $new_type->wc_id])->name;
                    if($new_type->phone_line == 1)
                        $xml_data['phone_line'] = "true";
                    else
                        $xml_data['phone_line'] = "false";
                    $xml_data['floors_total'] = $new_type->floor_all;
                    $xml_data['building_type'] = WallMaterial::findOne(['wall_material_id' => $new_type->wall_material_id])->name;
                    $xml_data['apartment'] = $new_type->number_apartment;

                    $error_pointer['type'] = $new_type->type_object_id;
                    $error_pointer['id'] = $new_type->id;

                    $xml_data['phonelist'] = explode(",", $new_type->phone);
                    $xml_data['price_value'] = $new_type->price;
                    if ($new_type->city_or_region == 0){
                        $xml_data['locality_name'] = 'Харьков';
                        if(isset($new_type->region_kharkiv_admin_id) && $new_type->region_kharkiv_admin_id != 0){
                            $xml_data['sub_locality_name'] = RegionKharkivAdmin::findOne(['region_kharkiv_admin_id' => region_kharkiv_admin_id])->name." район";
                        }
                    }else{
                        $regName = Region::findOne(['region_id' => $new_type->region_id])->name;
                        $locality_name = Locality::findOne(['locality_id' => $new_type->locality_id])->name;
                        $pattern = '/\(.+\)/i';
                        $xml_data['locality_name'] = preg_replace($pattern, "",$locality_name);
                        $xml_data['district'] = $regName;
                    }
                    $xml_data['address'] = Street::findOne(['street_id' => $new_type->street_id])->name;
                    //TODO сделать фильтр для улица, проспект итп!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                    if(isset($new_type->number_building)){
                        $xml_data['address'] .= ", ";
                        $xml_data['address'] .= $new_type->number_building;
                        $xml_data['address'] = trim($xml_data['address']);
                        if(isset($new_type->corps)){
                            $xml_data['address'] .= '/'.$new_type->corps;
                            trim($xml_data['address']);
                        }
                    }
                    $xml_data['description'] = $new_type->notesite;
                    $images = $new_type->getImages();
                    foreach($images as $img) {
                        if($img) array_push($photos_arr, Url::base(true).'/'.$img->getPathToOrigin());
                    }
                    break;
                }
                case 'house':{
                    /*дома и дачи*/
                    $house_type = House::findOne(['id' => $elem['type_id']]);
                    if(!$house_type) break;
                    $xml_data['type'] = "продажа";
                    $xml_data['property_type'] = 'жилая';
                    if ($house_type->type_object_id == 7){
                        $xml_data['category_obj'] = "дом";
                    }
                    if ($house_type->type_object_id == 8){
                        $xml_data['category_obj'] = "дача";
                    }
                    $xml_data['creation_date'] = $house_type->date_added;
                    $xml_data['last_update_date'] = $house_type->date_modified;
                    if($house_type->metro_id != 0){
                        $xml_data['metro_name'] = Metro::findOne(['metro_id' => $house_type->metro_id])->name;
                    }
                    $xml_data['currency'] = 'USD';
                    $xml_data['lot_area_value'] = $house_type->total_area;
                    $xml_data['lot_area_unit'] = "кв. м";
                    $xml_data['living_space_value'] = $house_type->total_area_house;
                    $xml_data['living_space_unit'] = "кв. м";
                    $xml_data['rooms'] = $house_type->count_room;
                    $xml_data['floor'] = $house_type->floor_all;
                    if($house_type->phone_line == 1)
                        $xml_data['phone_line'] = "true";
                    else
                        $xml_data['phone_line'] = "false";
                    $xml_data['building_type'] = WallMaterial::findOne(['wall_material_id' => $house_type->wall_material_id])->name;
                    $error_pointer['type'] = $house_type->type_object_id;
                    $error_pointer['id'] = $house_type->id;

                    $xml_data['phonelist'] = explode(",", $house_type->phone);
                    $xml_data['price_value'] = $house_type->price;
                    if ($house_type->city_or_region == 0){
                        $xml_data['locality_name'] = 'Харьков';
                        if(isset($house_type->region_kharkiv_admin_id) && $house_type->region_kharkiv_admin_id != 0){
                            $xml_data['sub_locality_name'] = RegionKharkivAdmin::findOne(['region_kharkiv_admin_id' => region_kharkiv_admin_id])->name." район";
                        }
                    }else{
                        $regName = Region::findOne(['region_id' => $house_type->region_id])->name;
                        $locality_name = Locality::findOne(['locality_id' => $house_type->locality_id])->name;
                        $pattern = '/\(.+\)/i';
                        $xml_data['locality_name'] = preg_replace($pattern, "",$locality_name);
                        $xml_data['district'] = $regName;
                    }
                    $xml_data['address'] = Street::findOne(['street_id' => $house_type->street_id])->name;
                    //TODO сделать фильтр для улица, проспект итп!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                    if(isset($house_type->number_building)){
                        $xml_data['address'] .= ", ";
                        $xml_data['address'] .= $house_type->number_building;
                        $xml_data['address'] = trim($xml_data['address']);
                        if(isset($house_type->corps)){
                            $xml_data['address'] .= '/'.$house_type->corps;
                            trim($xml_data['address']);
                        }
                    }
                    $xml_data['description'] = $house_type->notesite;
                    $images = $house_type->getImages();
                    foreach($images as $img) {
                        if($img) array_push($photos_arr, Url::base(true).'/'.$img->getPathToOrigin());
                    }
                    break;
                }
                case 'area':{
                    /*земельные участки */
                    $area_type = Area::findOne(['id' => $elem['type_id']]);
                    if(!$area_type) break;
                    $xml_data['type'] = "продажа";
                    $xml_data['property_type'] = 'земельные участки';
                    $xml_data['category_obj'] = "участок";
                    $xml_data['creation_date'] = $area_type->date_added;
                    $xml_data['last_update_date'] = $area_type->date_modified;
                    $xml_data['currency'] = 'USD';
                    $xml_data['lot_area_value'] = $area_type->total_area;
                    $xml_data['lot_area_unit'] = "кв. м";
                    if($area_type->phone_line == 1)
                        $xml_data['phone_line'] = "true";
                    else
                        $xml_data['phone_line'] = "false";
                    $error_pointer['type'] = $area_type->type_object_id;
                    $error_pointer['id'] = $area_type->id;

                    $xml_data['phonelist'] = explode(",", $area_type->phone);
                    $xml_data['price_value'] = $area_type->price;
                    if ($area_type->city_or_region == 0){
                        $xml_data['locality_name'] = 'Харьков';
                        if(isset($area_type->region_kharkiv_admin_id) && $area_type->region_kharkiv_admin_id != 0){
                            $xml_data['sub_locality_name'] = RegionKharkivAdmin::findOne(['region_kharkiv_admin_id' => region_kharkiv_admin_id])->name." район";
                        }
                    }else{
                        $regName = Region::findOne(['region_id' => $area_type->region_id])->name;
                        $locality_name = Locality::findOne(['locality_id' => $area_type->locality_id])->name;
                        $pattern = '/\(.+\)/i';
                        $xml_data['locality_name'] = preg_replace($pattern, "",$locality_name);
                        $xml_data['district'] = $regName;
                    }
                    $xml_data['address'] = Street::findOne(['street_id' => $area_type->street_id])->name;
                    //TODO сделать фильтр для улица, проспект итп!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                    if(isset($area_type->number_building)){
                        $xml_data['address'] .= ", ";
                        $xml_data['address'] .= $area_type->number_building;
                        $xml_data['address'] = trim($xml_data['address']);
                        if(isset($area_type->corps)){
                            $xml_data['address'] .= '/'.$area_type->corps;
                            trim($xml_data['address']);
                        }
                    }
                    $xml_data['description'] = $area_type->notesite;
                    $images = $area_type->getImages();
                    foreach($images as $img) {
                        if($img) array_push($photos_arr, Url::base(true).'/'.$img->getPathToOrigin());
                    }
                    break;
                }
                case 'commercial':{
                    $commercial_type = Commercial::findOne(['id' => $elem['type_id']]);
                    if(!$commercial_type) break;
                    $xml_data['type'] = "продажа";
                    $xml_data['property_type'] = 'коммерческая';
                    if ($commercial_type->type_object_id == 10){
                        $xml_data['category_obj'] = "гараж";
                    }

                    if ($commercial_type->type_object_id == 11){
                        $xml_data['category_obj'] = "офис";
                    }
                    $xml_data['creation_date'] = $commercial_type->date_added;
                    $xml_data['last_update_date'] = $commercial_type->date_modified;
                    if($commercial_type->metro_id != 0){
                        $xml_data['metro_name'] = Metro::findOne(['metro_id' => $commercial_type->metro_id])->name;
                    }
                    $xml_data['currency'] = 'USD';
                    $xml_data['new_flat'] = "да";
                    $xml_data['area_value'] = $commercial_type->total_area;
                    $xml_data['area_unit'] = "кв. м";
                    $xml_data['living_space_value'] = $commercial_type->total_area_house;
                    $xml_data['living_space_unit'] = "кв. м";
                    $xml_data['rooms'] = $commercial_type->count_room;
                    $xml_data['floor'] = $commercial_type->floor;
                    if($commercial_type->phone_line == 1)
                        $xml_data['phone_line'] = "true";
                    else
                        $xml_data['phone_line'] = "false";
                    $xml_data['floors_total'] = $commercial_type->floor_all;
                    $xml_data['apartment'] = $commercial_type->number_office;
                    $error_pointer['type'] = $commercial_type->type_object_id;
                    $error_pointer['id'] = $commercial_type->id;

                    $xml_data['phonelist'] = explode(",", $commercial_type->phone);
                    $xml_data['price_value'] = $commercial_type->price;
                    if ($commercial_type->city_or_region == 0){
                        $xml_data['locality_name'] = 'Харьков';
                        if(isset($commercial_type->region_kharkiv_admin_id) && $commercial_type->region_kharkiv_admin_id != 0){
                            $xml_data['sub_locality_name'] = RegionKharkivAdmin::findOne(['region_kharkiv_admin_id' => region_kharkiv_admin_id])->name." район";
                        }
                    }else{
                        $regName = Region::findOne(['region_id' => $commercial_type->region_id])->name;
                        $locality_name = Locality::findOne(['locality_id' => $commercial_type->locality_id])->name;
                        $pattern = '/\(.+\)/i';
                        $xml_data['locality_name'] = preg_replace($pattern, "",$locality_name);
                        $xml_data['district'] = $regName;
                    }
                    $xml_data['address'] = Street::findOne(['street_id' => $commercial_type->street_id])->name;
                    //TODO сделать фильтр для улица, проспект итп!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                    if(isset($commercial_type->number_building)){
                        $xml_data['address'] .= ", ";
                        $xml_data['address'] .= $commercial_type->number_building;
                        $xml_data['address'] = trim($xml_data['address']);
                        if(isset($commercial_type->corps)){
                            $xml_data['address'] .= '/'.$commercial_type->corps;
                            trim($xml_data['address']);
                        }
                    }
                    $xml_data['description'] = $commercial_type->notesite;
                    $images = $commercial_type->getImages();
                    foreach($images as $img) {
                        if($img) array_push($photos_arr, Url::base(true).'/'.$img->getPathToOrigin());
                    }
                    break;
                }
            }

            $xml_data['country'] = 'Украина';
            $xml_data['region'] = 'Харьковская область';

            /*ищем название категории через 2 таблицы*/
            if (isset($error_pointer['type']) && !empty($error_pointer['type'])){
                $type_real = TypeObject::findOne(['type_object_id' => $error_pointer['type']]);
                $category = TypeRealty::findOne(['type_realty_id' => $type_real->type_realty_id]);
            }

            $error_id_link = "<a href=\"".Url::base(true)."/".$elem['type']. "/update?id=".$elem['type_id']."\" target=\"_blank\">" .$error_pointer['id'] . "</a>";
            /*выносим и логгируем ошибки*/
            if (!isset($xml_data['type']) || empty($xml_data['type'])) {
                $arrErrors[] = 'Категория: ' . $category['name'] . ', id обьявления: ' . $error_id_link . ' Ошибка в обработке типа(EST)';
            }

            if (!isset($xml_data['description']) || empty($xml_data['description'])) {
                $arrErrors[] = 'Категория: ' . $category['name'] . ', id обьявления: ' . $error_id_link . ' Ошибка: отсутствует описание(EST)';
            }

            if (!isset($xml_data['price_value']) || empty($xml_data['price_value'])) {
                $arrErrors[] = 'Категория: ' . $category['name'] . ', id обьявления: ' . $error_pointer['id'] . ' Ошибка в обработке цены(EST)';
            }

            //Fill--------------------------------------------------------------
            if (empty($arrErrors)) {
                /*все хорошо, формируем дальше*/
                $offer = $est->addChild('offer');
                $offer->addAttribute('internal-id', $xml_data['local_reality_id']);
                $offer->addChild('type', $xml_data['type']);
                $offer->addChild('property-type', $xml_data['property_type']);
                $offer->addChild('category', $xml_data['category_obj']);
                if(isset($xml_data['url']))
                    $offer->addChild('url', $xml_data['url']);
                if($xml_data['creation_date'] != '0000-00-00 00:00:00')
                    $offer->addChild('creation-date', date(DATE_ATOM,time($xml_data['creation_date'])));
                if($xml_data['last_update_date'] != '0000-00-00 00:00:00')
                    $offer->addChild('last-update-date', date(DATE_ATOM, time($xml_data['last_update_date'])));
                $location = $offer->addChild('location');
                $location->addChild('country', $xml_data['country']);
                $location->addChild('region', $xml_data['region']);
                if(isset($xml_data['sub_locality_name']))
                    $location->addChild('sub-locality-name', $xml_data['sub_locality_name']);
                if(isset($xml_data['district']))
                    $location->addChild('district', $xml_data['district']);
                $location->addChild('locality-name', $xml_data['locality_name']);
                $location->addChild('address', $xml_data['address']);
                if(isset($xml_data['apartment']) && $xml_data['apartment'] != '')
                    $location->addChild('apartment', $xml_data['apartment']);
                if(isset($xml_data['metro_name'])){
                    $metro = $location->addChild('metro');
                    $metro->addChild('name', $xml_data['metro_name']);
                }
                $sales_agent_phone = $offer->addChild('sales-agent');
                foreach ($xml_data['phonelist'] as $phone) {
                    $phone = preg_replace('/\s/','',$phone);
                    //$phone = trim($phone);
                    switch (strlen($phone)) {
                        case '10':
                            $phone = "+38".$phone;
                            break;
                        case '7':
                            $phone = "+38057".$phone;
                            break;
                        case '6':
                            $phone = "+380572".$phone;
                            break;
                    }
                    $sales_agent_phone->addChild('phone', $phone);
                }

                $price = $offer->addChild('price');
                $price->addChild('value', $xml_data['price_value']);
                $price->addChild('currency', $xml_data['currency']);
                if(isset($xml_data['area_value'])){
                    $area = $offer->addChild('area');
                    $area->addChild('value', $xml_data['area_value']);
                    $area->addChild('unit', $xml_data['area_unit']);
                }
                if(isset($xml_data['living_space_value'])){
                    $living_space = $offer->addChild('living-space');
                    $living_space->addChild('value', $xml_data['living_space_value']);
                    $living_space->addChild('unit', $xml_data['living_space_unit']);
                }
                if(isset($xml_data['kitchen_space_value'])){
                    $kitchen_space = $offer->addChild('kitchen-space');
                    $kitchen_space->addChild('value', $xml_data['kitchen_space_value']);
                    $kitchen_space->addChild('unit', $xml_data['kitchen_space_unit']);
                }
                if(isset($xml_data['lot_area_value'])){
                    $lot_area = $offer->addChild('lot-area');
                    $lot_area->addChild('value', $xml_data['lot_area_value']);
                    $lot_area->addChild('unit', $xml_data['lot_area_unit']);
                }
                if(isset($xml_data['new_flat']))
                    $offer->addChild('new-flat', $xml_data['new_flat']);
                if(isset($xml_data['rooms']))
                    $offer->addChild('rooms', $xml_data['rooms']);
                if(isset($xml_data['floor']))
                    $offer->addChild('floor', $xml_data['floor']);
                if(isset($xml_data['studio']))
                    $offer->addChild('studio', $xml_data['studio']);
                if(isset($xml_data['open_plan']))
                    $offer->addChild('open-plan', $xml_data['open_plan']);
                if(isset($xml_data['rooms_type']))
                    $offer->addChild('rooms-type', $xml_data['rooms_type']);
                if(isset($xml_data['balcony']))
                    $offer->addChild('balcony', $xml_data['balcony']);
                if(isset($xml_data['bathroom_unit']))
                    $offer->addChild('bathroom-unit', $xml_data['bathroom_unit']);
                if(isset($xml_data['phone_line']))
                    $offer->addChild('phone', $xml_data['phone_line']);
                if(isset($xml_data['floors_total']))
                    $offer->addChild('floors-total', $xml_data['floors_total']);
                if(isset($xml_data['building_type']))
                    $offer->addChild('building-type', $xml_data['building_type']);
                if(isset($xml_data['description']))
                    $offer->addChild('description', $xml_data['description']);

                if (isset($photos_arr) && !empty($photos_arr)){
                    $max_photo = 5;
                    foreach ($photos_arr as $photo){
                        if ($max_photo > 0){
                            $offer->addChild('image', $photo);
                            $max_photo--;
                        }
                    }
                }
            }else{
                $data['errors'][] = $arrErrors;
            }
        }
        /*заливаем все в XML, и сообщение об успешной записи в админку*/
        if (file_put_contents('xmls/est.xml', $est->asXML())){
            $data['xml_success'][] = "Файл XML для est успешно перезаписан";
        }else{
            $data['xml_success'][] = "В результате перезаписи XML файла est произошла ошибка. Пожалуйста сделайте скриншот и обратитесь к разработчикам.";
        }
        return $data;
        //var_dump($data);
        /*est*/
    }

    public function createMestoXml(){
        /*mesto.ua*/
        $property = Xml::find()->where(['mesto' => 1])->all();;
        $mesto = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><properties></properties>');
        foreach ($property as $elem){
            $arrErrors = [];
            $photos_arr = [];
            $xml_id = $elem['id'];
            switch ($elem['type']){
                case 'rent' : {
                    $deal_type = 'rent';
                    //доделать аренду(объектов пока нет)
                    $currency = 'UAH';
                    //$error_pointer['type'] = $commercial_type['type_object_id'];
                    //$error_pointer['id'] = $commercial_type['commercial_id'];
                    break;
                }
                case 'commercial':{
                    $deal_type = 'sale';
                    $commercial_type = Commercial::findOne(['id' => $elem['type_id']]);
                    if(!$commercial_type) break;
                    if ($commercial_type->type_object_id == 10){
                        $property_type = 'garages';
                    }
                    if ($commercial_type->type_object_id == 11){
                        $property_type = 'commercial';
                    }
                    $rooms = $commercial_type->count_room;
                    $area = $commercial_type->total_area;
                    $floor = $commercial_type->floor;
                    $floors_total = $commercial_type->floor_all;
                    $currency = 'USD';
                    if ($commercial_type->city_or_region == 0){
                        $city = 'Харьков';
                    }else{
                        $city = Region::findOne(['region_id' => $commercial_type->region_id])->name;
                    }
                    $addr_country = 'UA';
                    $addr_city = 'Харьковская область';
                    $addr_city .= ', '.$city;
                    $addr_street = Street::findOne(['street_id' => $commercial_type->street_id])->name;
                    //сделать фильтр для улица, проспект итп!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                    if(isset($commercial_type->number_office)){
                        $addr_house = $commercial_type->number_office;
                        $addr_house = trim($addr_house);
                        if(isset($commercial_type->corps)){
                            $addr_house .= '/'.$commercial_type->corps;
                            trim($addr_house);
                        }
                    }
                    $description = $commercial_type->notesite;
                    $price = $commercial_type->price;
                    $phonelist = explode(",", $commercial_type->phone);
                    $images = $commercial_type->getImages();
                    foreach($images as $img) {
                        if($img) array_push($photos_arr, Url::base(true).'/'.$img->getPathToOrigin());
                    }
                    $error_pointer['type'] = $commercial_type->type_object_id;
                    $error_pointer['id'] = $commercial_type->id;
                    break;
                }
                case 'apartment':{
                    $deal_type = 'sale';
                    $apartment_type = Apartment::findOne(['id' => $elem['type_id']]);
                    if(!$apartment_type) break;
                    if ($apartment_type->type_object_id == 1){
                        $property_type = 'flat';
                        $type_building = 10;
                    }
                    if ($apartment_type->type_object_id == 12){
                        $property_type = 'flat';
                    }
                    if ($apartment_type->type_object_id == 2){
                        $property_type = 'room';
                    }
                    $rooms = (int)$apartment_type->count_room;
                    $area = $apartment_type->total_area;
                    $area_living = $apartment_type->floor_area;
                    $area_kitchen = $apartment_type->kitchen_area;
                    $floor = $apartment_type->floor;
                    $floors_total = $apartment_type->floor_all;
                    if($apartment_type->layout_id){
                        switch ($apartment_type->layout_id) {
                            case '9':
                                $building_layout = 1;
                                break;
                            case '12':
                                $building_layout = 2;
                                break;
                            case '13':
                                $building_layout = 3;
                                break;
                            case '11':
                                $building_layout = 4;
                                break;
                        }
                    }
                    if($apartment_type->wall_material_id){
                        switch ($apartment_type->wall_material_id) {
                            case '2':
                                $building_walls = 1;
                                break;
                            case '12':
                                $building_walls = 2;
                                break;
                            case '1':
                                $building_walls = 3;
                                break;
                            case '13':
                                $building_walls = 4;
                                break;
                            case '14':
                                $building_walls = 5;
                                break;
                        }
                    }
                    $currency = 'USD';

                    if ($apartment_type->city_or_region == 0){
                        $city = 'Харьков';
                    }else{
                        $city = Region::findOne(['region_id' => $apartment_type->region_id])->name;
                    }
                    $addr_country = 'UA';
                    $addr_city = 'Харьковская область';
                    $addr_city .= ', '.$city;
                    $addr_street = Street::findOne(['street_id' => $apartment_type->street_id])->name;
                    //сделать фильтр для улица, проспект итп!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                    if(isset($apartment_type->number_building)){
                        $addr_house = $apartment_type->number_building;
                        $addr_house = trim($addr_house);
                        if(isset($apartment_type->corps)){
                            $addr_house .= '/'.$apartment_type->corps;
                            trim($addr_house);
                        }
                    }
                    $description = $apartment_type->notesite;
                    $price = $apartment_type->price;
                    $phonelist = explode(",", $apartment_type->phone);
                    $images = $apartment_type->getImages();
                    foreach($images as $img) {
                        if($img) array_push($photos_arr, Url::base(true).'/'.$img->getPathToOrigin());
                    }
                    $error_pointer['type'] = $apartment_type->type_object_id;
                    $error_pointer['id'] = $apartment_type->id;
                    break;
                }
                case 'building' : {
                    $deal_type = 'sale';
                    $building_type = Building::findOne(['id' => $elem['type_id']]);
                    if(!$building_type) break;
                    if ($building_type->type_object_id == 3){
                        $property_type = 'house';
                        $type_building = 5;
                    }
                    if ($building_type->type_object_id == 4){
                        $property_type = 'flat';
                        $type_building = 5;
                    }
                    $rooms = (int)$building_type->count_room;
                    $area = $building_type->total_area;
                    $area_living = $building_type->floor_area;
                    $area_kitchen = $building_type->kitchen_area;
                    $floor = $building_type->floor;
                    $floors_total = $building_type->floor_all;
                    if($building_type->layout_id){
                        switch ($building_type->layout_id) {
                            case '9':
                                $building_layout = 1;
                                break;
                            case '12':
                                $building_layout = 2;
                                break;
                            case '13':
                                $building_layout = 3;
                                break;
                            case '11':
                                $building_layout = 4;
                                break;
                        }
                    }
                    if($building_type->wall_material_id){
                        switch ($building_type->wall_material_id) {
                            case '2':
                                $building_walls = 1;
                                break;
                            case '12':
                                $building_walls = 2;
                                break;
                            case '1':
                                $building_walls = 3;
                                break;
                            case '13':
                                $building_walls = 4;
                                break;
                            case '14':
                                $building_walls = 5;
                                break;
                        }
                    }
                    $currency = 'USD';
                    if ($building_type->city_or_region == 0){
                        $city = 'Харьков';
                    }else{
                        $city = Region::findOne(['region_id' => $building_type->region_id])->name;
                    }
                    $addr_country = 'UA';
                    $addr_city = 'Харьковская область';
                    $addr_city .= ', '.$city;
                    $addr_street = Street::findOne(['street_id' => $building_type->street_id])->name;
                    //сделать фильтр для улица, проспект итп!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                    if(isset($building_type->number_building)){
                        $addr_house = $building_type->number_building;
                        $addr_house = trim($addr_house);
                        if(isset($building_type->corps)){
                            $addr_house .= '/'.$building_type->corps;
                            trim($addr_house);
                        }
                    }
                    $description = $building_type->notesite;
                    $price = $building_type->price;
                    $phonelist = explode(",", $building_type->phone);
                    $images = $building_type->getImages();
                    foreach($images as $img) {
                        if($img) array_push($photos_arr, Url::base(true).'/'.$img->getPathToOrigin());
                    }
                    $error_pointer['type'] = $building_type->type_object_id;
                    $error_pointer['id'] = $building_type->id;
                    break;
                }
                case 'area' : {
                    $deal_type = 'sale';
                    $property_type = 'plot';
                    $area_type = Area::findOne(['id' => $elem['type_id']]);
                    if(!$area_type) break;
                    $area = $area_type->total_area;
                    $currency = 'USD';
                    if ($area_type->city_or_region == 0){
                        $city = 'Харьков';
                    }else{
                        $city = Region::findOne(['region_id' => $area_type->region_id])->name;
                    }
                    $addr_country = 'UA';
                    $addr_city = 'Харьковская область';
                    $addr_city .= ', '.$city;
                    $addr_street = Street::findOne(['street_id' => $area_type->street_id])->name;
                    //сделать фильтр для улица, проспект итп!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                    if(isset($area_type->number_building)){
                        $addr_house = $area_type->number_building;
                        $addr_house = trim($addr_house);
                        if(isset($area_type->corps)){
                            $addr_house .= '/'.$area_type->corps;
                            trim($addr_house);
                        }
                    }
                    $description = $area_type->notesite;
                    $price = $area_type->price;
                    $phonelist = explode(",", $area_type->phone);
                    $images = $area_type->getImages();
                    foreach($images as $img) {
                        if($img) array_push($photos_arr, Url::base(true).'/'.$img->getPathToOrigin());
                    }
                    $error_pointer['type'] = $area_type->type_object_id;
                    $error_pointer['id'] = $area_type->id;
                    break;
                }
                case 'house' : {
                    $deal_type = 'sale';
                    $property_type = 'house';
                    $house_type = House::findOne(['id' => $elem['type_id']]);
                    if(!$house_type) break;
                    //нет разделения на дома и дачи
                    /*
                    if ($house_type['type_object_id'] == 7){
                        $property_type = 'house';
                    }
                    if ($house_type['type_object_id'] == 8){
                        $property_type = 'house';
                    }
                    */
                    $rooms = (int)$house_type->count_room;
                    $area = $house_type->total_area;
                    $area_living = $house_type->total_area_house;
                    if($house_type->wall_material_id){
                        switch ($house_type->wall_material_id) {
                            case '2':
                                $building_walls = 1;
                                break;
                            case '12':
                                $building_walls = 2;
                                break;
                            case '1':
                                $building_walls = 3;
                                break;
                            case '13':
                                $building_walls = 4;
                                break;
                            case '14':
                                $building_walls = 5;
                                break;
                        }
                    }
                    $currency = 'USD';
                    if ($house_type->city_or_region == 0){
                        $city = 'Харьков';
                    }else{
                        $city = Region::findOne(['region_id' => $house_type->region_id])->name;
                    }
                    $addr_country = 'UA';
                    $addr_city = 'Харьковская область';
                    $addr_city .= ', '.$city;
                    $addr_street = Street::findOne(['street_id' => $house_type->street_id])->name;
                    //сделать фильтр для улица, проспект итп!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                    if(isset($house_type->number_building)){
                        $addr_house = $house_type->number_building;
                        $addr_house = trim($addr_house);
                        if(isset($house_type->corps)){
                            $addr_house .= '/'.$house_type->corps;
                            trim($addr_house);
                        }
                    }
                    $description = $house_type->notesite;
                    $price = $house_type->price;
                    $phonelist = explode(",", $house_type->phone);
                    $images = $house_type->getImages();
                    foreach($images as $img) {
                        if($img) array_push($photos_arr, Url::base(true).'/'.$img->getPathToOrigin());
                    }
                    $error_pointer['type'] = $house_type->type_object_id;
                    $error_pointer['id'] = $house_type->id;
                    break;
                }
            }

            //errors
            if (isset($error_pointer['type']) && !empty($error_pointer['type'])){
                $type_real = TypeObject::findOne(['type_object_id' => $error_pointer['type']]);
                $category = TypeRealty::findOne(['type_realty_id' => $type_real->type_realty_id]);
            }
            //----------
            $error_id_link = "<a href=\"".Url::base(true)."/".$elem['type']. "/update?id=".$elem['type_id']."\" target=\"_blank\">" .$error_pointer['id'] . "</a>";
            if (empty($xml_id)){
                $arrErrors[] = 'Категория: ' . $category['name'] . ', id обьявления: ' . $error_id_link . ' Ошибка в обработке id(mesto.ua)';
            }
            if (!isset($deal_type) || empty($deal_type)) {
                $arrErrors[] = 'Категория: ' . $category['name'] . ', id обьявления: ' . $error_id_link . ' Ошибка в обработке типа сделки(mesto.ua)';
            }
            if (!isset($property_type) || empty($property_type)){
                $arrErrors[] = 'Категория: ' . $category['name'] . ', id обьявления: ' . $error_id_link . ' Ошибка в обработке типа недвижимости(mesto.ua)';
            }
            if (!isset($addr_city) || empty($addr_city)){
                $arrErrors[] = 'Категория: ' . $category['name'] . ', id обьявления: ' . $error_id_link . ' Ошибка в обработке населенного пункта(mesto.ua)';
            }
            if (!isset($addr_street) || empty($addr_street)){
                $arrErrors[] = 'Категория: ' . $category['name'] . ', id обьявления: ' . $error_id_link . ' Ошибка в обработке населенного улицы(mesto.ua)';
            }

            if (!isset($price) || empty($price)){
                $arrErrors[] = 'Категория: ' . $category['name'] . ', id обьявления: ' . $error_id_link . ' Ошибка в обработке цены(mesto.ua)';
            }
            if (!isset($currency) || empty($currency)){
                $arrErrors[] = 'Категория: ' . $category['name'] . ', id обьявления: ' . $error_id_link . ' Ошибка в обработке валюты(mesto.ua)';
            }
            if (!isset($phonelist) || empty($phonelist)){
                $arrErrors[] = 'Категория: ' . $category['name'] . ', id обьявления: ' . $error_id_link . ' Ошибка в обработке номера телефона(mesto.ua)';
            }
            if (!isset($description) || empty($description)){
                $arrErrors[] = 'Категория: ' . $category['name'] . ', id обьявления: ' . $error_id_link . ' Ошибка: отсутствует описание(mesto.ua)';
            }

            if (empty($arrErrors)) {
                /*все хорошо, формируем дальше*/
                $reality = $mesto->addChild('property');
                $reality->addChild('xml_id', $xml_id);
                $reality->addChild('deal_type', $deal_type);
                $reality->addChild('property_type', $property_type);
                $reality->addChild('addr_country', $addr_country);
                $reality->addChild('addr_city', $addr_city);
                $reality->addChild('addr_street', $addr_street);
                if(isset($addr_house))
                    $reality->addChild('addr_house', $addr_house);
                $reality->addChild('rooms', $rooms);
                $reality->addChild('area', $area);
                if(isset($area_living))
                    $reality->addChild('area_living', $area_living);
                if(isset($area_kitchen))
                    $reality->addChild('area_kitchen', $area_kitchen);
                $reality->addChild('floor', $floor);
                $reality->addChild('floors_total', $floors_total);
                $reality->addChild('building_type', $type_building);
                //$reality->addChild('building_type_other', $building_type_other);
                if(isset($building_layout))
                    $reality->addChild('building_layout', $building_layout);
                if(isset($building_walls))
                    $reality->addChild('building_walls', $building_walls);
                //$reality->addChild('building_windows', $building_windows);
                //$reality->addChild('building_heating', $building_heating);
                $reality->addChild('description', $description);
                $reality->addChild('price', $price);
                $reality->addChild('currency', $currency);
                //$reality->addChild('guests_limit', $guests_limit);
                //$reality->addChild('source_url', $source_url);
                //$reality->addChild('contact_person', $contact_person);
                $phones = $reality->addChild('phones');
                foreach ($phonelist as $phone) {
                    $phone = preg_replace('/\s/','',$phone);
                    //$phone = trim($phone);
                    switch (strlen($phone)) {
                        case '10':
                            $phone = "+38".$phone;
                            break;
                        case '7':
                            $phone = "+38057".$phone;
                            break;
                        case '6':
                            $phone = "+380572".$phone;
                            break;
                    }
                    $phones->addChild('phone', $phone);
                }
                //$facilities = $reality->addChild('facilities');
                //	$facilities->addChild('facility_id', $facility_id);
                if (isset($photos_arr) && !empty($photos_arr)){
                    $photos = $reality->addChild('photos');
                    $max_photo = 5;
                    foreach ($photos_arr as $photo){
                        if ($max_photo > 0){
                            $photos->addChild('photo_url', $photo);
                            $max_photo--;
                        }
                    }
                }
                //$paidplacements = $reality->addChild('paidplacements');
                //  $paidplacements->addChild('paidplacement', $paidplacement);
            }else{
                $data['errors'][] = $arrErrors;
            }
        }
        /*заливаем все в XML, и сообщение об успешной записи в админку*/
        if (file_put_contents('xmls/mesto.xml', $mesto->asXML())){
            $data['xml_success'][] = "Файл XML для mesto.ua успешно перезаписан";
        }else{
            $data['xml_success'][] = "В результате перезаписи XML файла mesto произошла ошибка. Пожалуйста сделайте скриншот и обратитесь к разработчикам.";
        }
        /*mesto.ua*/
        return $data;
        //var_dump($data);
    }

    public function actionCreateXml(){
        $data_besplatka = $this->createBesplatkaXml();
        $data_est = $this->createEstXml();
        $data_mesto = $this->createMestoXml();
        $new_time = XmlData::findOne(['name' => 'timestamp']);
        $new_time->value = time();
        $new_time->save();
        $data = array_merge_recursive($data_besplatka, $data_est, $data_mesto);
        $timestamp = XmlData::getTimestamp();
        return $this->render('create', [
            'data' => $data, 'timestamp' => $timestamp,
        ]);
    }

    public function actionShowXmlObjects($resource){
        $query = Xml::find()->where([$resource => '1']);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => '6']);
        $property_objects = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        //$property_objects = Xml::findAll([$resource => '1']);
        //$model = [];
        foreach ($property_objects as $obj){
            switch ($obj->type){
                case 'apartment' : {
                    $key = '../apartment/update?id='.$obj->type_id;
                    $model[$key] = Apartment::findOne(['id' => $obj->type_id]);
                    break;
                }
                case 'house' : {
                    $key = '../house/update?id='.$obj->type_id;
                    $model[$key] = House::findOne(['id' => $obj->type_id]);
                    break;
                }
                case 'building' : {
                    $key = '../building/update?id='.$obj->type_id;
                    $model[$key] = Building::findOne(['id' => $obj->type_id]);
                    break;
                }
                case 'area' : {
                    $key = '../area/update?id='.$obj->type_id;
                    $model[$key] = Area::findOne(['id' => $obj->type_id]);
                    break;
                }
                case 'commercial' : {
                    $key = '../commercial/update?id='.$obj->type_id;
                    $model[$key] = Commercial::findOne(['id' => $obj->type_id]);
                    break;
                }
                case 'rent' : {
                    $key = '../rent/update?id='.$obj->type_id;
                    $model[$key] = Rent::findOne(['id' => $obj->type_id]);
                    break;
                }
            }
        }
        return $this->render('objectlist-view', ['model' => $model, 'pages' => $pages, 'resource' => $resource]);
    }
}
