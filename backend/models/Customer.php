<?php

namespace backend\models;

use backend\models\Condit;
use backend\models\Region;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
 */
class Customer extends ActiveRecord
{
    const AVAILABLE_TYPES = [
        'flats', 'new_buildings', 'houses'
    ];

    const AVAILABLE_TYPES_LABELS = [
        'flats' => 'Квартиры',
        'new_buildings' => 'Новостройки',
        'houses' => 'Дома',
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
            [['full_name', 'price_from', 'price_to', 'total_area_from', 'total_area_to', 'type'], 'required'],
            [['price_from', 'price_to', 'total_area_from', 'total_area_to', 'is_public'], 'integer'],
            [['info'], 'string'],
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
            'full_name' => 'Full Name',
            'type' => 'Type',
            'phone' => 'Phone',
            'price_from' => 'Price From',
            'price_to' => 'Price To',
            'total_area_from' => 'Total Area From',
            'total_area_to' => 'Total Area To',
            'info' => 'Info',
            'is_public' => 'Is Public',
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
        $this->loadCondits($data);

        return true;
    }

    /**
     * @param array $data
     */
    public function loadRegions(array $data)
    {
        $className = $this->getClassName();

        if (isset($data[$className]['regions'])) {
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

        if (!$insert) {
            if ($this->getOldAttribute('type') &&
                $this->getOldAttribute('type') != $this->type) {
                return false;
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
