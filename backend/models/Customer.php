<?php

namespace backend\models;

use backend\models\Condit;
use backend\models\Region;
use backend\models\RegionKharkiv;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\ServerErrorHttpException;

/**
 * This is the model class for table "customers".
 *
 * @property integer $id
 * @property string $full_name
 * @property string $type
 * @property string $phone
 * @property integer $price_from
 * @property integer $price_to
 * @property integer $total_area_from
 * @property integer $total_area_to
 * @property string $info
 * @property integer $is_public
 *
 * @property Condit[] $condits
 * @property Region[] $regions
 * @property RegionKharkiv[] $regionsKharkiv
 * @property RegionKharkiv[] $regionsKharkivCopy
 * @property Locality[] $localities
 * @property CustomerViewedAd[] $customerViewedAd
 */
class Customer extends ActiveRecord
{
    public $viewedCount;
    public $notViewedCount;

    const AVAILABLE_TYPES = [
        'flats',
        'new_buildings',
        'houses',
        'flats-new_buildings',
        'land_plot',
        'commercial',
        'rent_house',
        'rent_flat',
        'rent_commercial'
    ];

    const AVAILABLE_TYPES_LABELS = [
        'flats' => 'Только квартира (вторичка)',
        'new_buildings' => 'Только новострой',
        'houses' => 'Дома',
        'flats-new_buildings' => 'Квартиры/новостройки',
        'land_plot' => 'Участки',
        'commercial' => 'Коммерция',
        'rent_house' => 'АРЕНДА дом',
        'rent_flat' => 'АРЕНДА квартира',
        'rent_commercial' => 'АРЕНДА коммерция'
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price_from', 'price_to', 'total_area_from', 'total_area_to', 'type', 'phone'], 'required'],
            [['price_from', 'price_to', 'total_area_from', 'total_area_to', 'is_public'], 'integer'],
            [['info'], 'string'],
            ['phone', 'match', 'pattern' => '/((\+)?38)?(0\d{2}|\(0\d{2}\))\s(\d{7}|\d{3}-\d{2}-\d{2})/'],
            [['full_name', 'phone', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'ФИО',
            'type' => 'Тип недвижимости',
            'phone' => 'Телефон',
            'price_from' => 'Цена от',
            'price_to' => 'Цена до',
            'total_area_from' => 'Общая площадь от',
            'total_area_to' => 'Общая площадь до',
            'info' => 'Инфо',
            'is_public' => 'Публичный',
            'city_or_region' => Yii::t('app', 'City Or Region'),
            'region_kharkiv_admin_id' => Yii::t('yii', 'Region Kharkiv Admin'),
            'locality_id' => Yii::t('yii', 'Locality'),
            'course_id' => Yii::t('yii', 'Course'),
            'region_id' => Yii::t('yii', 'Region'),
            'region_kharkiv_id' => Yii::t('yii', 'Region Kharkiv'),
            'street_id' => Yii::t('yii', 'Street'),
            'number_building' => Yii::t('yii', 'Number Building'),
            'metro_id' => Yii::t('yii', 'Metro'),
            'localities' => 'Населенный(е) пункт'
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCondits()
    {
        return $this->hasMany(Condit::className(), ['condit_id' => 'condit_id'])
            ->viaTable('customers_condits', ['customer_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRegions()
    {
        return $this->hasMany(Region::className(), ['region_id' => 'region_id'])
            ->viaTable('customers_regions', ['customer_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRegionsKharkiv()
    {
        return $this->hasMany(RegionKharkiv::className(), ['region_kharkiv_id' => 'region_kharkiv_id'])
            ->viaTable('customers_regions_kharkiv', ['customer_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRegionsKharkivCopy()
    {
        return $this->getRegionsKharkiv();
    }

    /**
     * @return ActiveQuery
     */
    public function getLocalities()
    {
        return $this->hasMany(Locality::className(), ['locality_id' => 'locality_id'])
            ->viaTable('customers_localities', ['customer_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(CustomerLocation::className(), ['customer_id' => 'id']);
    }

    public function getCustomerViewedAd()
    {
        return $this->hasMany(CustomerViewedAd::className(), ['customer_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function load($data, $formName = null, $created = false)
    {
        if ($created && isset($data[$this->getClassName()]['types'])) {
            if (!$type = $this->loadTypes($data, $formName)) {
                return false;
            }
            $this->setAttribute('type', $type);

            if (!parent::load($data, $formName) || !$this->save()) {
                return false;
            }
        } else {
            if (!parent::load($data, $formName) || !$this->save()) {
                return false;
            }
        }

        $this->loadRegions($data);
        $this->loadRegionsKharkiv($data);
        $this->loadCondits($data);
        $this->loadLocalities($data);

        return true;
    }

    /**
     * @param array $data
     */
    public function loadRegions(array $data)
    {
        $className = $this->getClassName();

        if (isset($data[$className]['regions']) && $data[$className]['regions'] !== '') {
            foreach ($data[$className]['regions'] as $regionId) {
                $region = Region::findOne($regionId);

                if (!$region) {
                    continue;
                }

                $this->link('regions', $region);
            }
        }
    }

    /**
     * @param array $data
     */
    public function loadRegionsKharkiv(array $data)
    {
        $className = $this->getClassName();

        if (isset($data[$className]['regionsKharkivCopy']) && $this->getAttribute('type') === 'houses') {
            $data[$className]['regionsKharkiv'] = $data[$className]['regionsKharkivCopy'];
        }

        $customerId = $this->id;

        Yii::$app->db->createCommand(
            "DELETE FROM customers_regions_kharkiv WHERE customer_id=${customerId}"
        )->execute();

        if (isset($data[$className]['regionsKharkiv']) && is_array($data[$className]['regionsKharkiv'])) {
            foreach ($data[$className]['regionsKharkiv'] as $regionId) {
                $region = RegionKharkiv::findOne($regionId);

                if (!$region) {
                    continue;
                }

                $regionKharkivId = $region->region_kharkiv_id;
                $post = Yii::$app->db->createCommand(
                    "SELECT * FROM customers_regions_kharkiv WHERE region_kharkiv_id=${regionKharkivId} AND customer_id=${customerId}"
                )->queryOne();

                if (!$post) {
                    $this->link('regionsKharkiv', $region);
                }
            }
        }
    }

    public function loadLocalities(array $data)
    {
        $className = $this->getClassName();

        $customerId = $this->id;

        Yii::$app->db->createCommand(
            "DELETE FROM customers_localities WHERE customer_id=${customerId}"
        )->execute();

        if (isset($data[$className]['localities']) && $data[$className]['localities'] !== '') {
            foreach ($data[$className]['localities'] as $regionId) {
                $region = Locality::findOne($regionId);

                if (!$region) {
                    continue;
                }

                $localityId = $region->locality_id;
                $post = Yii::$app->db->createCommand(
                    "SELECT * FROM customers_localities WHERE locality_id=${localityId} AND customer_id=${customerId}"
                )->queryOne();

                if (!$post) {
                    $this->link('localities', $region);
                }
            }
        }
    }

    public function loadLocation(array $data)
    {
        $className = $this->getClassName();
        $customerLocation = CustomerLocation::find()
            ->where(['customer_id' => $this->id])
            ->one();

        if ($customerLocation === null) {
            $customerLocation = new CustomerLocation();
        }
        $values = [
            'customer_id' => $this->id,
        ];
        if (isset($data[$className]['region_kharkiv_id']) && $data[$className]['region_kharkiv_id'] !== '') {
            $regionKharkiv = RegionKharkiv::findOne($data[$className]['region_kharkiv_id']);
            $values['region_kharkiv_id'] = $regionKharkiv->region_kharkiv_id;
        }
        if (isset($data[$className]['locality_id']) && $data[$className]['locality_id'] !== '') {
            $locality = Locality::findOne($data[$className]['locality_id']);
            $values['locality_id'] = $locality->locality_id;
        }

        if (count($values) > 1) {
            $customerLocation->attributes = $values;
            $customerLocation->save();
        }
    }

    /**
     * @param array $data
     */
    public function loadCondits(array $data)
    {
        $className = $this->getClassName();

        if (isset($data[$className]['condits']) && $data[$className]['condits'] && count($data[$className]['condits'])) {
            foreach ($data[$className]['condits'] as $conditId) {
                $condit = Condit::findOne($conditId);

                if (!$condit) {
                    continue;
                }

                $this->link('condits', $condit);
            }
        }
        else{
            $this->unlinkAll('condits',true);
        }
    }

    /**
     * @param array $data
     * @param null $formName
     * @return string|bool
     */
    public function loadTypes(array $data, $formName = null)
    {
        $className = $this->getClassName();

        if ($types = $data[$className]['types']) {
            $currentType = array_shift($types);

            if (in_array($currentType, self::AVAILABLE_TYPES)) {
                $this->setAttribute('type', $currentType);
            }

            $loadData = $data;
            unset($loadData[$className]['types']);

            foreach ($types as $type) {
                if (in_array($type, self::AVAILABLE_TYPES)) {
                    $newCustomer = new self();
                    $loadData[$className]['type'] = $type;

                    if (!$newCustomer->load($loadData, $formName)) {
                        return false;
                    }
                }
            }

            return $currentType;
        } else {
            return false;
        }
    }

    public function getClassName()
    {
        $namespace = explode("\\", self::className());
        return $namespace[count($namespace) - 1];
    }

    /**
     * @inheritdoc
     */
    public function link($name, $model, $extraColumns = [])
    {
        $exists = false;

        if ($name == 'regions') {
            $exists = $this->getRegions()
                ->where(['region_id' => $model->getPrimaryKey()])
                ->exists();
        }

        if ($name == 'condits') {
            $exists = $this->getCondits()
                ->where(['condit_id' => $model->getPrimaryKey()])
                ->exists();
        }

        if (!$exists) {
            parent::link($name, $model, $extraColumns);
        }
    }


    /**
     * @inheritDoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // normalize phone
        if ($this->isAttributeChanged('phone')) {
            if (
                preg_match('/((\+)?38)?(0\d{2}|\(0\d{2}\))\s(\d{7}|\d{3}-\d{2}-\d{2})/',
                    $this->getAttribute('phone')) === 1
            ) {
                $properPhone = str_replace(['-', '+',' ', '(', ')'], '', $this->getAttribute('phone'));
                if (strlen($properPhone) == 10) {
                    $properPhone = '38' . $properPhone;
                }

                $this->setAttribute('phone', $properPhone);
            } else {
                throw new ServerErrorHttpException('Неправильный формат номера телефона');
            }
        }

        if (!$insert) {
            if ($this->getOldAttribute('type') &&
                $this->getOldAttribute('type') != $this->type) {
                return false;
            }
        }

        if ($this->getAttribute('is_public')) {
            if ($this->getAttribute('phone')) {
                $similar = self::find()->where(['phone' => $this->getAttribute('phone')])->all();

                if (count($similar) > 0) {
                    throw new ServerErrorHttpException('Такой телефон уже имеется в базе');
                }
            }
        }

        return true;
    }

    public function gettypes()
    {
        return [];
    }

    public function settypes(array $types)
    {
    }
}
