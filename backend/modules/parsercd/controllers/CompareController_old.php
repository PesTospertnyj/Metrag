<?php

namespace app\modules\parsercd\controllers;

use Yii;
use yii\web\Controller;

use app\modules\parsercd\models\Parsercd;
use app\modules\parsercd\models\ParsercdSearch;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

class CompareController extends Controller
{
    /**
     * Функция нормализует (разбивает строку по запятой и убирает лишние символы) поле номера телефонов
     *
     * @param $value
     * @return array
     */
    private static function normalizePhoneNumbersField($value)
    {
        $phones = [];

        $chunks = explode(',', $value);
        foreach ($chunks as $chunk) {
            $chunk = str_replace([' ', '+', '-'], '', $chunk);

            $phones[] = $chunk;
        }

        return $phones;
    }

    public function actionIndex()
    {
        /** @var Parsercd[] $items */
        $items = Parsercd::find()->all();

        foreach ($items as $item) {
            $numbers = self::normalizePhoneNumbersField($item->phone);

            $sql = '';
            foreach ($numbers as $n => $number) {
                // первый номер
                if ($n === 0) {
                    $sql .= '`phone` LIKE "%' . $number . '%"';
                } else {
                    $sql .= ' OR `phone` LIKE "%' . $number . '%"';
                }
            }

            // Syntax sugar
            $update_status = function ($value) use ($item) {
                Yii::$app->db->createCommand("UPDATE `parsercd` SET 
                    `status` = {$value} WHERE id = {$item->id}")->execute();
            };

            $update_counter = function ($value) use ($item) {
                Yii::$app->db->createCommand("UPDATE `parsercd` SET 
                    `count_similar_advs` = {$value} WHERE id = {$item->id}")->execute();
            };

            // $similarPhonesCount показывает сколько квартир с номера текущего
            // объявления было найдено
            $similarPhonesCount = Yii::$app->db->createCommand(
                "SELECT COUNT(*) FROM `apartment` WHERE ({$sql})")->queryScalar();

            // `Если совпадает телефон - мы помечаем нашу квартиру статусом "2"`
            if ($similarPhonesCount > 0) {
                $update_status(2);
                $update_counter($similarPhonesCount);
            }

            // $similarPhonesAndRoomsCount показывает сколько квартир с номера текущего + к-во комнат
            // объявления было найдено
            $similarPhonesAndRoomsCount = Yii::$app->db->createCommand(
                "SELECT COUNT(*) FROM `apartment` WHERE ({$sql}) AND count_room = {$item->count_room}")->queryScalar();

            // `если совпадает телефон и кол-во комнат - помечаем статусом "3"`
            if ($similarPhonesAndRoomsCount > 0) {
                $update_status(3);
                $update_counter($similarPhonesAndRoomsCount);
            }

            // $similarPhonesAndRoomsAndFloorsCount показывает сколько квартир с номера текущего + к-во комнат + этажность
            // объявления было найдено
            $similarPhonesAndRoomsAndFloorsCount = Yii::$app->db->createCommand(
                "SELECT COUNT(*) FROM `apartment` WHERE ({$sql}) AND count_room = {$item->count_room}
                  AND floor_all = {$item->floor_all}")->queryScalar();

            // `если совпадает телефон, кол-во комнат и кол-во этажей - помечаем статусом "4" `
            if ($similarPhonesAndRoomsAndFloorsCount > 0) {
                $update_status(4);
                $update_counter($similarPhonesAndRoomsAndFloorsCount);
            }

            // $similarPhonesAndRoomsAndFloorsCount показывает сколько квартир с номера текущего + к-во комнат + этажность
            // объявления было найдено
            $similarPhonesAndRoomsAndFloorsAndFloorCount = Yii::$app->db->createCommand(
                "SELECT COUNT(*) FROM `apartment` WHERE ({$sql}) AND count_room = {$item->count_room}
                  AND floor_all = {$item->floor_all} AND floor = {$item->floor}")->queryScalar();

            // `и наконец если совпадает совпадает телефон, кол-во комнат и кол-во этажей и этажность дома - помечаем статусом "5".`
            if ($similarPhonesAndRoomsAndFloorsAndFloorCount > 0) {
                $update_status(5);
                $update_counter($similarPhonesAndRoomsAndFloorsAndFloorCount);
            }

        }

        return $this->redirect(Url::base(true).'/parsercd/default/index');
    }

    public function actionSimilar($id)
    {
        /** @var Parsercd $item */
        $item = Parsercd::find()->where(['id' => $id])->one();
        if ($item === null) {
            throw new NotFoundHttpException();
        }

        $numbers = self::normalizePhoneNumbersField($item->phone);

        $sql = '';
        foreach ($numbers as $n => $number) {
            // первый номер
            if ($n === 0) {
                $sql .= '`phone` LIKE "%' . $number . '%"';
            } else {
                $sql .= ' OR `phone` LIKE "%' . $number . '%"';
            }
        }

        $status = (int)$item->status;

        switch ($status) {
            case 2:
                $sql_query = "SELECT * FROM `apartment` WHERE ({$sql})";
                break;
            case 3:
                $sql_query = "SELECT * FROM `apartment` WHERE ({$sql}) AND count_room = {$item->count_room}";
                break;
            case 4:
                $sql_query = "SELECT * FROM `apartment` WHERE ({$sql}) AND count_room = {$item->count_room}
                  AND etajnost = {$item->floor_all}";
                break;
            case 5:
                $sql_query = "SELECT * FROM `apartment` WHERE ({$sql}) AND count_room = {$item->count_room}
                  AND floor_all = {$item->floor_all} AND floor = {$item->floor}";
                break;
        }

        $similarItems = Yii::$app->db->createCommand($sql_query)->queryAll();

        return $this->render('similar', [
            'item' => $item,
            'items' => $similarItems
        ]);
    }
}
