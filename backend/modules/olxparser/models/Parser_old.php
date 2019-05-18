<?php

namespace app\modules\olxparser\models;

use Yii;

/**
 * This is the model class for table "new_parser_olx_parser".
 *
 * @property integer $id
 * @property integer $advert_id
 * @property string $link
 * @property string $path
 * @property string $date
 * @property integer $type_object_id
 * @property string $advert_from
 * @property string $type
 * @property string $type_flat
 * @property integer $count_room
 * @property integer $floor
 * @property integer $floor_all
 * @property integer $total_area
 * @property integer $floor_area
 * @property integer $kitchen_area
 * @property string $price
 * @property string $phone
 * @property string $status
 * @property string $note
 * @property integer $kolfoto
 * @property string $image
 * @property string $view
 */
class Parser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'new_parser_olx_parser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['advert_id', 'link', 'path', 'date', 'type_object_id', 'advert_from', 'type', 'type_flat', 'count_room', 'floor', 'floor_all', 'total_area', 'floor_area', 'kitchen_area', 'price', 'phone', 'status', 'note', 'kolfoto', 'image', 'view'], 'required'],
            [['advert_id', 'type_object_id', 'count_room', 'floor', 'floor_all', 'total_area', 'floor_area', 'kitchen_area', 'kolfoto', 'enabled'], 'integer'],
            [['link', 'path', 'phone', 'status', 'note', 'image', 'view'], 'string'],
            [['date', 'advert_from', 'type', 'type_flat', 'price'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'advert_id' => 'ID объявления',
            'link' => 'Ссылка',
            'date' => 'Дата',
            'path' => 'Path',
            'type_object_id' => 'Type Object ID',
            'advert_from' => 'Объявление от',
            'type' => 'Тип',
            'type_flat' => 'Тип квартиры',
            'count_room' => 'Количество комнат',
            'floor' => 'Этаж',
            'floor_all' => 'Этажность дома',
            'total_area' => 'Общая площадь',
            'floor_area' => 'Жилая площадь',
            'kitchen_area' => 'Площадь кухни',
            'price' => 'Стоимость',
            'phone' => 'Телефон',
            'status' => 'Status',
            'note' => 'Описание',
            'kolfoto' => 'Количество фотографий',
            'image' => 'Ссылки на фото',
            //'view' => 'View',
        ];
    }
}
