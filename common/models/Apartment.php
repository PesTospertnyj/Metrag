<?php

namespace common\models;

use Yii;
use backend\models\Image;
use backend\models\TypeObject;
use backend\models\RegionKharkiv;
use backend\models\Street;
use backend\models\Course;
use backend\models\Locality;
use backend\models\Region;

/**
 * This is the model class for table "apartment".
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
 * @property integer $street
 * @property integer $street_id
 * @property string $number_building
 * @property string $corps
 * @property string $number_apartment
 * @property integer $exchange
 * @property string $exchange_formula
 * @property string $landmark
 * @property integer $condit_id
 * @property integer $source_info_id
 * @property string $price
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
class Apartment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'apartment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'type_object_id', 'count_room', 'floor', 'floor_all', 'price', 'source_info_id', 'total_area', 'floor_area', 'kitchen_area', 'condit_id', 'wc_id', 'wall_material_id', 'count_balcony', 'count_balcony_glazed'], 'required'],
            [['type_object_id', 'count_room', 'layout_id', 'floor', 'floor_all', 'city_or_region', 'region_kharkiv_admin_id', 'locality_id', 'course_id', 'region_id', 'region_kharkiv_id', 'street_id', 'exchange', 'condit_id', 'source_info_id', 'mediator_id', 'metro_id', 'wc_id', 'wall_material_id', 'count_balcony', 'count_balcony_glazed', 'exclusive_user_id', 'phone_line', 'bath', 'author_id', 'update_author_id', 'update_photo_user_id', 'enabled'], 'integer'],
            [['price', 'total_area', 'floor_area', 'kitchen_area'], 'number'],
            [['comment', 'note', 'notesite', 'street'], 'string'],
            [['date_added', 'date_modified', 'date_modified_photo', 'realty_state_id', 'is_publish', 'year_built', 'bathrooms', 'coordinate_lat', 'coordinate_long', 'description', 'status_publication', 'sub_type_id', 'deal_type_id', 'agent1_id', 'agent2_id', 'agent3_id'], 'safe'],
            [['number_building', 'corps', 'number_apartment', 'exchange_formula', 'landmark', 'phone'], 'string', 'max' => 255],
            [['region_kharkiv_admin_id', 'region_kharkiv_id'], 'required', 'when' => function ($model) {
                return $model->city_or_region == 0;
            }, 'whenClient' => "function(attribute, value) {
                console.log($(\"input[name='Apartment[city_or_region]']:checked\").val());
                return $(\"input[name='Apartment[city_or_region]']:checked\").val() == 0;
            }"],
            [['locality_id', 'course_id', 'region_id'], 'required', 'when' => function ($model) {
                    return $model->city_or_region == 1;
                }, 'whenClient' => "function(attribute, value) {
                    console.log($(\"input[name='Apartment[city_or_region]']:checked\").val());
                    return $(\"input[name='Apartment[city_or_region]']:checked\").val() == 1;
                }"],
        ];
    }

    /**
     * @inheritdoc
     */
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yii', 'ID'),
            'type_object_id' => \Yii::t('yii', 'Type Object'),
            'count_room' => \Yii::t('yii', 'Count Room'),
            'layout_id' => \Yii::t('yii', 'Layout'),
            'floor' => \Yii::t('yii', 'Floor'),
            'floor_all' => Yii::t('yii', 'Floor All'),
            'city_or_region' => Yii::t('yii', 'City Or Region'),
            'region_kharkiv_admin_id' => Yii::t('yii', 'Region Kharkiv Admin'),
            'locality_id' => Yii::t('yii', 'Locality'),
            'course_id' => Yii::t('yii', 'Course'),
            'region_id' => Yii::t('yii', 'Region'),
            'region_kharkiv_id' => Yii::t('yii', 'Region Kharkiv'),
            'street' => Yii::t('yii', 'Street'),
            'street_id' => 'Улица(старое название)',
            'number_building' => Yii::t('yii', 'Number Building'),
            'corps' => Yii::t('yii', 'Corps'),
            'number_apartment' => Yii::t('yii', 'Number Apartment'),
            'exchange' => Yii::t('yii', 'Exchange'),
            'exchange_formula' => Yii::t('yii', 'Exchange Formula'),
            'landmark' => Yii::t('yii', 'Landmark'),
            'condit_id' => Yii::t('yii', 'Condit'),
            'source_info_id' => Yii::t('yii', 'Source Info'),
            'price' => Yii::t('yii', 'Price'),
            'mediator_id' => Yii::t('yii', 'Mediator'),
            'metro_id' => Yii::t('yii', 'Metro'),
            'phone' => Yii::t('yii', 'Phone'),
            'total_area' => Yii::t('yii', 'Total Area'),
            'floor_area' => Yii::t('yii', 'Floor Area'),
            'kitchen_area' => Yii::t('yii', 'Kitchen Area'),
            'wc_id' => Yii::t('yii', 'Wc'),
            'wall_material_id' => Yii::t('yii', 'Wall Material'),
            'count_balcony' => Yii::t('yii', 'Count Balcony'),
            'count_balcony_glazed' => Yii::t('yii', 'Count Balcony Glazed'),
            'exclusive_user_id' => Yii::t('yii', 'Exclusive User'),
            'phone_line' => Yii::t('yii', 'Phone Line'),
            'bath' => Yii::t('yii', 'Bath'),
            'comment' => Yii::t('yii', 'Comment'),
            'note' => Yii::t('yii', 'Note'),
            'notesite' => Yii::t('yii', 'Notesite'),
            'date_added' => Yii::t('yii', 'Date Added'),
            'date_modified' => Yii::t('yii', 'Date Modified'),
            'date_modified_photo' => Yii::t('yii', 'Date Modified Photo'),
            'author_id' => Yii::t('yii', 'Author'),
            'update_author_id' => Yii::t('yii', 'Update Author'),
            'update_photo_user_id' => Yii::t('yii', 'Update Photo User'),
            'enabled' => Yii::t('yii', 'Enabled'),
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
        $model = Apartment::findOne($image->itemId);
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
    public function street()
    {
        return $this->hasOne('Backend\Street');
    }
    public function layout()
    {
        return $this->hasOne('Backend\Layout');
    }

}
