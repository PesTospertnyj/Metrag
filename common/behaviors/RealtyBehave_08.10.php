<?php

namespace common\behaviors;

use backend\models\Xml;
use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

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
use backend\models\Metro;
use backend\models\User;
use backend\models\UserType;
use backend\models\Layout;
use backend\models\SourceInfo;
use backend\models\Mediator;
use backend\models\Developer;
use backend\models\Partsite;
use backend\models\Parthouse;
use backend\models\Gas;
use backend\models\Comfort;
use backend\models\Sewage;
use backend\models\Water;
use backend\models\Purpose;
use backend\models\Ownership;
use backend\models\Communication;



class RealtyBehave extends Behavior
{
    public $imageFiles;
    public $besplatka;
    public $est;
    public $mesto;

    public function getTypeObject()
    {
        return TypeObject::findOne($this->owner->type_object_id);
    }

    public function getbathValue()
    {
        if ($this->owner->bath == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function gettvValue()
    {
        if ($this->owner->tv == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getrefrigeratorValue()
    {
        if ($this->owner->refrigerator == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getentryValue()
    {
        if ($this->owner->entry == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getHouseDemolitionValue()
    {
        if ($this->owner->house_demolition == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getElectricValue()
    {
        if ($this->owner->electric == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getwasherValue()
    {
        if ($this->owner->washer == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getfurnitureValue()
    {
        if ($this->owner->furniture == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getconditionerValue()
    {
        if ($this->owner->conditioner == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getgarageValue()
    {
        if ($this->owner->garage == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getLayout()
    {
        return Layout::findOne($this->owner->layout_id);
    }

    public function getPurpose()
    {
        return Purpose::findOne($this->owner->purpose_id);
    }

    public function getPartsite()
    {
        return Partsite::findOne($this->owner->partsite_id);
    }

    public function getParthouse()
    {
        return Parthouse::findOne($this->owner->parthouse_id);
    }

    public function getCityOrRegion()
    {
        if ($this->owner->city_or_region == 0) return Yii::t('app', 'Kharkiv');
        else return Yii::t('app', 'Region');
    }

    public function getLocality()
    {
        return Locality::findOne($this->owner->locality_id);
    }

    public function getCourse()
    {
        return Course::findOne($this->owner->course_id);
    }

    public function getRegion()
    {
        return Region::findOne($this->owner->region_id);
    }

    public function getSewage()
    {
        return Sewage::findOne($this->owner->sewage_id);
    }

    public function getRegionKharkiv()
    {
        return RegionKharkiv::findOne($this->owner->region_kharkiv_id);
    }

    public function getRegionKharkivAdmin()
    {
        return RegionKharkivAdmin::findOne($this->owner->region_kharkiv_admin_id);
    }

    public function getStreet()
    {
        return Street::findOne($this->owner->street_id);
    }

    public function getGas()
    {
        return Gas::findOne($this->owner->gas_id);
    }

    public function getWater()
    {
        return Water::findOne($this->owner->water_id);
    }

    public function getComfort()
    {
        return Comfort::findOne($this->owner->comfort_id);
    }

    public function getCommunication()
    {
        return Communication::findOne($this->owner->communication_id);
    }

    public function getExchangeValue()
    {
        if ($this->owner->exchange == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getHousingValue()
    {
        if ($this->owner->housing == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getStateActValue()
    {
        if ($this->owner->state_act == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getDocumentsValue()
    {
        if ($this->owner->documents == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getRentValue()
    {
        if ($this->owner->rent == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getTopicalityValue()
    {
        if ($this->owner->topicality == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getAvtorampaValue()
    {
        if ($this->owner->avtorampa == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getRedLineValue()
    {
        if ($this->owner->red_line == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getInfinitePeriodValue()
    {
        if ($this->owner->infinite_period == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getDetachedBuildingValue()
    {
        if ($this->owner->detached_building == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getSeparateEntranceValue()
    {
        if ($this->owner->separate_entrance == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getDeliveredValue()
    {
        if ($this->owner->delivered == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getCondit()
    {
        return Condit::findOne($this->owner->condit_id);
    }

    public function getOwnership()
    {
        return Ownership::findOne($this->owner->ownership_id);
    }

    public function getSourceInfo()
    {
        return SourceInfo::findOne($this->owner->source_info_id);
    }

    public function getMediator()
    {
        return Mediator::findOne($this->owner->mediator_id);
    }

    public function getMetro()
    {
        return Metro::findOne($this->owner->metro_id);
    }

    public function getWc()
    {
        return Wc::findOne($this->owner->wc_id);
    }

    public function getWallMaterial()
    {
        return WallMaterial::findOne($this->owner->wall_material_id);
    }

    public function getexclusiveUser()
    {
        return User::findOne($this->owner->exclusive_user_id);
    }

    public function getauthor()
    {
        return User::findOne($this->owner->author_id);
    }

    public function getupdateAuthor()
    {
        return User::findOne($this->owner->update_author_id);
    }

    public function getupdatePhotoUser()
    {
        return User::findOne($this->owner->update_photo_user_id);
    }

    public function getdeveloper()
    {
        return Developer::findOne($this->owner->developer_id);
    }

    public function getenabledValue()
    {
        if ($this->owner->enabled == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getphoneLineValue()
    {
        if ($this->owner->phone_line == 0) return Yii::t('app', 'No');
        else return Yii::t('app', 'Yes');
    }

    public function getPhonesArr($phone)
    {
        return $phones = explode(",", $phone);
    }

    public function upload()
    {
        if ($this->owner->validate()) {
            foreach ($this->owner->imageFiles as $file) {
                $path = Yii::getAlias('@webroot/upload/files/') . $file->name;
                $file->saveAs($path);
                $this->owner->attachImage($path);
            }
            return true;
        } else {
            return false;
        }
    }

    public function getResouseBoards($type){
        $boards = Xml::findOne(['type_id' => $this->owner->id, 'type' => $type]);
        if($boards){
            $this->owner->besplatka = $boards->besplatka;
            $this->owner->est = $boards->est;
            $this->owner->mesto = $boards->mesto;
        }
    }

    public function setResourseBoards($type){
        $boards = Xml::findOne(['type_id' => $this->owner->id, 'type' => $type]);
        if($boards){
            $boards->besplatka = $this->owner->besplatka;
            $boards->est = $this->owner->est;
            $boards->mesto = $this->owner->mesto;
            $boards->save();
        }else{
            if($this->owner->besplatka || $this->owner->est || $this->owner->mesto) {
                $boards = new Xml();
                $boards->type = $type;
                $boards->type_id = $this->owner->id;
                $boards->besplatka = $this->owner->besplatka;
                $boards->est = $this->owner->est;
                $boards->mesto = $this->owner->mesto;
                $boards->save();
            }
        }
    }

    public function is_active(){
        if($this->owner->enabled == 1) {
            return true;
        }else {
            return false;
        }
    }
}
?>