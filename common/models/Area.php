<?php

namespace common\models;

use backend\models\Course;
use backend\models\Locality;
use backend\models\Region;
use Yii;
use backend\models\Image;
/**
 * This is the model class for table "area".
 *
 * @property integer $id
 * @property integer $type_object_id
 * @property integer $partsite_id
 * @property integer $city_or_region
 * @property integer $region_kharkiv_admin_id
 * @property integer $locality_id
 * @property integer $course_id
 * @property integer $region_id
 * @property integer $region_kharkiv_id
 * @property integer $street_id
 * @property string $number_building
 * @property integer $exchange
 * @property string $exchange_formula
 * @property string $landmark
 * @property integer $source_info_id
 * @property string $price
 * @property integer $mediator_id
 * @property string $phone
 * @property integer $water_id
 * @property string $total_area
 * @property integer $sewage_id
 * @property integer $purpose_id
 * @property integer $gas_id
 * @property integer $house_demolition
 * @property integer $exclusive_user_id
 * @property integer $phone_line
 * @property integer $state_act
 * @property integer $electric
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
class Area extends \yii\db\ActiveRecord
{
    public $imageFiles;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_object_id', 'partsite_id', 'city_or_region', 'price', 'source_info_id', 'sewage_id', 'total_area', 'water_id',
                 'gas_id', 'enabled', 'phone'], 'required'],
            [['type_object_id', 'partsite_id', 'city_or_region', 'region_kharkiv_admin_id', 'locality_id', 'course_id',
                'region_id', 'region_kharkiv_id', 'street_id', 'exchange', 'source_info_id', 'mediator_id', 'water_id',
                'sewage_id', 'purpose_id', 'gas_id', 'house_demolition', 'exclusive_user_id', 'phone_line', 'state_act',
                'electric', 'author_id', 'update_author_id', 'update_photo_user_id', 'enabled', 'metro_id'], 'integer'],
            [['price', 'total_area'], 'number'],
            [['comment', 'note', 'notesite', 'street'], 'string'],
            [['date_added', 'date_modified', 'date_modified_photo', 'realty_state_id', 'is_publish', 'year_built', 'bathrooms', 'coordinate_lat', 'coordinate_long', 'description', 'status_publication', 'sub_type_id', 'deal_type_id', 'agent1_id', 'agent2_id', 'agent3_id'], 'safe'],
            [['number_building', 'exchange_formula', 'landmark', 'phone'], 'string', 'max' => 255],
            [['region_kharkiv_admin_id', 'region_kharkiv_id'], 'required', 'when' => function ($model) {
                return $model->city_or_region == 0;
            }, 'whenClient' => "function(attribute, value) {
                console.log($(\"input[name='Area[city_or_region]']:checked\").val());
                return $(\"input[name='Area[city_or_region]']:checked\").val() == 0;
            }"],
            [['locality_id', 'course_id', 'region_id'], 'required', 'when' => function ($model) {
                return $model->city_or_region == 1;
            }, 'whenClient' => "function(attribute, value) {
                    console.log($(\"input[name='Area[city_or_region]']:checked\").val());
                    return $(\"input[name='Area[city_or_region]']:checked\").val() == 1;
                }"],
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
            'partsite_id' => Yii::t('app', 'Partsite'),
            'city_or_region' => Yii::t('app', 'City Or Region'),
            'region_kharkiv_admin_id' => Yii::t('app', 'Region Kharkiv Admin'),
            'locality_id' => Yii::t('app', 'Locality'),
            'course_id' => Yii::t('app', 'Course'),
            'region_id' => Yii::t('app', 'Region'),
            'region_kharkiv_id' => Yii::t('app', 'Region Kharkiv'),
            'street' => Yii::t('app', 'Street'),
            'street_id' => 'Улица(старое название)',
            'number_building' => Yii::t('app', 'Number Building'),
            'exchange' => Yii::t('app', 'Exchange'),
            'exchange_formula' => Yii::t('app', 'Exchange Formula'),
            'landmark' => Yii::t('app', 'Landmark'),
            'source_info_id' => Yii::t('app', 'Source Info'),
            'price' => Yii::t('app', 'Price'),
            'mediator_id' => Yii::t('app', 'Mediator'),
            'phone' => Yii::t('app', 'Phone'),
            'water_id' => Yii::t('app', 'Water'),
            'total_area' => Yii::t('app', 'Total Area'),
            'sewage_id' => Yii::t('app', 'Sewage'),
            'purpose_id' => Yii::t('app', 'Purpose'),
            'gas_id' => Yii::t('app', 'Gas'),
            'house_demolition' => Yii::t('app', 'House Demolition'),
            'exclusive_user_id' => Yii::t('app', 'Exclusive User'),
            'phone_line' => Yii::t('app', 'Phone Line'),
            'state_act' => Yii::t('app', 'State Act'),
            'electric' => Yii::t('app', 'Electric'),
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
        $model = Area::findOne($image->itemId);
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
    public function metro()
    {
        return $this->hasOne('Backend\Metro');
    }
}
