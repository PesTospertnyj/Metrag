<?php

namespace common\models;

use backend\models\Course;
use backend\models\Locality;
use backend\models\Region;
use Yii;
use backend\models\Image;

/**
 * This is the model class for table "building".
 *
 * @property integer $id
 * @property integer $type_object_id
 * @property integer $count_room
 * @property integer $layout_id
 * @property integer $floor
 * @property integer $floor_all
 * @property integer $city_or_region
 * @property integer $region_kharkiv_admin_id
 * @property integer $locality_id
 * @property integer $course_id
 * @property integer $region_id
 * @property integer $region_kharkiv_id
 * @property integer $street_id
 * @property string $number_building
 * @property string $corps
 * @property string $number_apartment
 * @property integer $exchange
 * @property string $exchange_formula
 * @property integer $developer_id
 * @property string $landmark
 * @property integer $condit_id
 * @property integer $source_info_id
 * @property string $price
 * @property string $price_square_meter
 * @property integer $mediator_id
 * @property integer $metro_id
 * @property string $phone
 * @property string $total_area
 * @property string $floor_area
 * @property string $kitchen_area
 * @property integer $wc_id
 * @property integer $wall_material_id
 * @property integer $count_balcony
 * @property integer $count_balcony_glazed
 * @property integer $exclusive_user_id
 * @property integer $phone_line
 * @property integer $bath
 * @property string $comment
 * @property string $note
 * @property string $notesite
 * @property string $date_added
 * @property string $date_modified
 * @property string $date_modified_photo
 * @property integer $author_id
 * @property integer $update_author_id
 * @property integer $update_photo_user_id
 * @property integer $enabled
 */
class Building extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'building';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_object_id', 'count_room', 'floor', 'floor_all', 'city_or_region', 'price', 'condit_id', 'source_info_id', 'wc_id',
                'wall_material_id', 'total_area', 'floor_area', 'kitchen_area', 'count_balcony', 'count_balcony_glazed', 'phone', 'enabled'], 'required'],
            [['type_object_id', 'count_room', 'layout_id', 'floor', 'floor_all', 'city_or_region', 'region_kharkiv_admin_id', 'locality_id',
                'course_id', 'region_id', 'region_kharkiv_id', 'street_id', 'exchange', 'developer_id', 'condit_id', 'source_info_id', 'mediator_id',
                'metro_id', 'wc_id', 'wall_material_id', 'count_balcony', 'count_balcony_glazed', 'exclusive_user_id', 'phone_line', 'bath',
                'author_id', 'update_author_id', 'update_photo_user_id', 'enabled'], 'integer'],
            [['price', 'price_square_meter', 'total_area', 'floor_area', 'kitchen_area'], 'number'],
            [['comment', 'note', 'notesite', 'street'], 'string'],
            [['date_added', 'date_modified', 'date_modified_photo', 'realty_state_id', 'is_publish', 'year_built', 'bathrooms', 'coordinate_lat', 'coordinate_long', 'description', 'status_publication', 'sub_type_id', 'deal_type_id', 'lived_complex_id', 'agent1_id', 'agent2_id', 'agent3_id'], 'safe'],
            [['number_building', 'corps', 'number_apartment', 'exchange_formula', 'landmark', 'phone'], 'string', 'max' => 255],
            [['region_kharkiv_admin_id', 'region_kharkiv_id'], 'required', 'when' => function ($model) {
                return $model->city_or_region == 0;
            }, 'whenClient' => "function(attribute, value) {
                console.log($(\"input[name='Building[city_or_region]']:checked\").val());
                return $(\"input[name='Building[city_or_region]']:checked\").val() == 0;
            }"],
            [['locality_id', 'course_id', 'region_id'], 'required', 'when' => function ($model) {
                return $model->city_or_region == 1;
            }, 'whenClient' => "function(attribute, value) {
                    console.log($(\"input[name='Building[city_or_region]']:checked\").val());
                    return $(\"input[name='Building[city_or_region]']:checked\").val() == 1;
                }"],
        ];
    }

    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ],
            'realty' => [
                'class' => 'common\behaviors\RealtyBehave',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type_object_id' => Yii::t('app', 'Type Object'),
            'count_room' => Yii::t('app', 'Count Room'),
            'layout_id' => Yii::t('app', 'Layout'),
            'floor' => Yii::t('app', 'Floor'),
            'floor_all' => Yii::t('app', 'Floor All'),
            'city_or_region' => Yii::t('app', 'City Or Region'),
            'region_kharkiv_admin_id' => Yii::t('app', 'Region Kharkiv Admin'),
            'locality_id' => Yii::t('app', 'Locality'),
            'course_id' => Yii::t('app', 'Course'),
            'region_id' => Yii::t('app', 'Region'),
            'region_kharkiv_id' => Yii::t('app', 'Region Kharkiv'),
            'street' => Yii::t('app', 'Street'),
            'street_id' => 'Улица(старое название)',
            'number_building' => Yii::t('app', 'Number Building'),
            'corps' => Yii::t('app', 'Corps'),
            'number_apartment' => Yii::t('app', 'Number Apartment'),
            'exchange' => Yii::t('app', 'Exchange'),
            'exchange_formula' => Yii::t('app', 'Exchange Formula'),
            'developer_id' => Yii::t('app', 'Developer'),
            'landmark' => Yii::t('app', 'Landmark'),
            'condit_id' => Yii::t('app', 'Condit'),
            'source_info_id' => Yii::t('app', 'Source Info'),
            'price' => Yii::t('app', 'Price'),
            'price_square_meter' => Yii::t('app', 'Price Square Meter'),
            'mediator_id' => Yii::t('app', 'Mediator'),
            'metro_id' => Yii::t('app', 'Metro'),
            'phone' => Yii::t('app', 'Phone'),
            'total_area' => Yii::t('app', 'Total Area'),
            'floor_area' => Yii::t('app', 'Floor Area'),
            'kitchen_area' => Yii::t('app', 'Kitchen Area'),
            'wc_id' => Yii::t('app', 'Wc'),
            'wall_material_id' => Yii::t('app', 'Wall Material'),
            'count_balcony' => Yii::t('app', 'Count Balcony'),
            'count_balcony_glazed' => Yii::t('app', 'Count Balcony Glazed'),
            'exclusive_user_id' => Yii::t('app', 'Exclusive User'),
            'phone_line' => Yii::t('app', 'Phone Line'),
            'bath' => Yii::t('app', 'Bath'),
            'comment' => Yii::t('app', 'Comment'),
            'note' => Yii::t('app', 'Note'),
            'notesite' => Yii::t('app', 'Notesite'),
            'date_added' => Yii::t('app', 'Date Added'),
            'date_modified' => Yii::t('app', 'Date Modified'),
            'date_modified_photo' => Yii::t('app', 'Date Modified Photo'),
            'author_id' => Yii::t('app', 'Author'),
            'update_author_id' => Yii::t('app', 'Update Author'),
            'update_photo_user_id' => Yii::t('app', 'Update Photo User'),
            'enabled' => Yii::t('app', 'Enabled'),
        ];
    }

    // Remove agents if not public
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if (!$this->is_publish) {
            $this->agent1_id = 0;
            $this->agent2_id = 0;
            $this->agent3_id = 0;
        }

        return true;
    }

    public static function deleteImage($id)
    {
        $image = Image::findOne($id);
        $model = Building::findOne($image->itemId);
        $images = $model->getImages();
        foreach ($images as $img)
        {
            if ($img->id == $id)
                $model->removeImage($img);
        }
    }

    public function getLocalitystring($model)
    {
        $locality = '';
        if($model['city_or_region'] == '0') {
            $locality .= Yii::t('app', 'Kharkiv');
        }else {
            if ($model['locality_id']) $locality .= Locality::findOne($model['locality_id'])->name . ', ';
            if ($model['course_id']) $locality .= Course::findOne($model['course_id'])->name . ', ';
            if ($model['region_id']) $locality .= Region::findOne($model['region_id'])->name;
        }
        if($model['region_kharkiv_id'] != '0'){
            $locality .= ', ';
            $locality .= RegionKharkiv::findOne($model['region_kharkiv_id'])->name;
        }
        if($model['street_id'] != '0'){
            $locality .= ', ';
            $locality .= Street::findOne($model['street_id'])->name;
        }
        return $locality;
    }

    public function getTypeObject($model = null)
    {
        if($model == null)
            return TypeObject::findOne($this->type_object_id);
        else
            return TypeObject::findOne($model['type_object_id'])->name;

    }

    public function getRegionKharkiv($model = null)
    {
        if($model == null)
            return RegionKharkiv::findOne($this->region_kharkiv_id);
        else
            return RegionKharkiv::findOne($model['region_kharkiv_id'])->name;

    }
}
