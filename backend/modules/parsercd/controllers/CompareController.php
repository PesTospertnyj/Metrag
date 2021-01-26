<?php

namespace app\modules\parsercd\controllers;

use app\modules\parsercd\models\ParsercdLog;
use Yii;
use yii\db\Exception;
use yii\web\Controller;

use app\modules\parsercd\models\Parsercd;
use app\modules\parsercd\models\ParsercdSearch;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

class CompareController extends Controller
{
    /**
     * ������� ����������� (��������� ������ �� ������� � ������� ������ �������) ���� ������ ���������
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
        //if(!empty($phones))
        return $phones;
    }

    public function actionOldIndex()
    {
        /** @var Parsercd[] $items */
        $items = Parsercd::find()->all();

        foreach ($items as $item) {
            $numbers = self::normalizePhoneNumbersField($item->phone);

            $sql = '';
            foreach ($numbers as $n => $number) {
                // ������ �����
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

            // $similarPhonesCount ���������� ������� ������� � ������ ��������
            // ���������� ���� �������
            $similarPhonesCount = Yii::$app->db->createCommand(
                "SELECT COUNT(*) FROM `apartment` WHERE ({$sql})")->queryScalar();

            // `���� ��������� ������� - �� �������� ���� �������� �������� "2"`
            if ($similarPhonesCount > 0) {
                $update_status(2);
                $update_counter($similarPhonesCount);
            }

            // $similarPhonesAndRoomsCount ���������� ������� ������� � ������ �������� + �-�� ������
            // ���������� ���� �������
            $similarPhonesAndRoomsCount = Yii::$app->db->createCommand(
                "SELECT COUNT(*) FROM `apartment` WHERE ({$sql}) AND count_room = {$item->count_room}")->queryScalar();

            // `���� ��������� ������� � ���-�� ������ - �������� �������� "3"`
            if ($similarPhonesAndRoomsCount > 0) {
                $update_status(3);
                $update_counter($similarPhonesAndRoomsCount);
            }

            // $similarPhonesAndRoomsAndFloorsCount ���������� ������� ������� � ������ �������� + �-�� ������ + ���������
            // ���������� ���� �������
            $similarPhonesAndRoomsAndFloorsCount = Yii::$app->db->createCommand(
                "SELECT COUNT(*) FROM `apartment` WHERE ({$sql}) AND count_room = {$item->count_room}
                  AND floor_all = {$item->floor_all}")->queryScalar();

            // `���� ��������� �������, ���-�� ������ � ���-�� ������ - �������� �������� "4" `
            if ($similarPhonesAndRoomsAndFloorsCount > 0) {
                $update_status(4);
                $update_counter($similarPhonesAndRoomsAndFloorsCount);
            }

            // $similarPhonesAndRoomsAndFloorsCount ���������� ������� ������� � ������ �������� + �-�� ������ + ���������
            // ���������� ���� �������
            $similarPhonesAndRoomsAndFloorsAndFloorCount = Yii::$app->db->createCommand(
                "SELECT COUNT(*) FROM `apartment` WHERE ({$sql}) AND count_room = {$item->count_room}
                  AND floor_all = {$item->floor_all} AND floor = {$item->floor}")->queryScalar();

            // `� ������� ���� ��������� ��������� �������, ���-�� ������ � ���-�� ������ � ��������� ���� - �������� �������� "5".`
            if ($similarPhonesAndRoomsAndFloorsAndFloorCount > 0) {
                $update_status(5);
                $update_counter($similarPhonesAndRoomsAndFloorsAndFloorCount);
            }

        }

        return $this->redirect(Url::base(true) . '/parsercd/default/index');
    }


    private function deleteWhereTheSameLinks()
    {
        //https://www.olx.ua/obyavlenie/prodam-2k-kvartiru-v-novostroyke-zhk-balakireva-ot-zhs1-na-pavlovom-pole-IDB0OeK.html
    }

    private function setNewStatus(array $data = null, $status)
    {
        $ids = [];
        if ($data) {
            //������ � ������ ��� ���� id ��� �������� ���������.
            foreach ($data as $element) {
                $ids[] = $element['id'];
            }
        }

        $ids = implode(',', $ids);





        //similar links
        $links = '';
        foreach($data as $element) {
            $links .= $this->getSimilarLink($element['id']);
            //$param['id']
        }

        //$data

        //var_dump($links); exit;



       // var_dump($ids, $status);


        //try {
            return (bool)Yii::$app->db->createCommand(
                "UPDATE parsercd
                      SET status = '" . $status . "', similar_links = '" . $links . "', count_similar_advs = '" . count($data) . "'
                      WHERE id IN($ids)")
                ->execute();

        //} catch (\Exception $e) {
        //    return false;
        //}

    }

    private function setNewStatusAllColumns(array $params)//: bool
    {
        $status = '�������, �������, ����';

        $data = Yii::$app->db->createCommand(
            "SELECT id
                  FROM `parsercd`
                  WHERE phone LIKE :phone AND
                  count_room = :count_room AND
                  floor = :floor")
            ->bindValues($params)
            ->queryAll();


        if ($data) {
            return $this->setNewStatus($data, $status);
        }
        return false;
    }

    private function setNewStatusPhoneFloor(array $params)//: bool
    {
        $status = '�������, ����';

        $data = Yii::$app->db->createCommand(
            "SELECT id
                  FROM `parsercd`
                  WHERE phone LIKE :phone AND
                  floor = :floor")
            ->bindValues($params)
            ->queryAll();

        if ($data) {
            return $this->setNewStatus($data, $status);
        }
        return false;
    }

    private function setNewStatusPhoneRooms(array $params)//: bool
    {
        $status = '�������, �������';

        $data = Yii::$app->db->createCommand(
            "SELECT id
                  FROM `parsercd`
                  WHERE phone LIKE :phone AND
                  count_room = :count_room")
            ->bindValues($params)
            ->queryAll();

        if ($data) {
            return $this->setNewStatus($data, $status);
        }
        return false;
    }
    private function getSimilarLink($id)
    {
        return '<a href="https://admin.metrag.com.ua/admin/apartment/add-from-parsercd?id=' . $id . '">' . $id . '</a>, ';
    }
    private function setStatusPhone(array $params)//: bool
    {
        $status = '�������� �������';


        $data = Yii::$app->db->createCommand(
            "SELECT id
                  FROM `parsercd`
                  WHERE phone LIKE :phone")
            ->bindValues($params)
            ->queryAll();
//        $data = Yii::$app->db->createCommand(
//            "SELECT id
//                  FROM `parsercd`
//                  WHERE phone LIKE :phone AND
//                  count_room = :count_room AND
//                  floor = :floor")
//            ->bindValues($params)
//            ->queryAll();







        if ($data) {
            return $this->setNewStatus($data, $status);
        }
        return false;
    }


//
//
//    //����� �������.
//    public function actionCompareitems($start = 0)
//    {
//
////        $items = Parsercd::find()->orderBy('id')->offset($start)//->limit(5)
////        ->where('phone LIKE :phone', ['phone' => '%0930043890%'])
////            ->all();
//
//        //
//        //������ ������	region_kharkiv_id	street_id	metro_id	link1	link2	date	type_object_id	count_room	floor	floor_all	total_area	floor_area	kitchen_area	price	phone	status	note	kolfoto	image	view	count_similar_advs	enabled	id
//
//
//        try {
//            $items = Parsercd::find()->orderBy('id')
//                ->offset($start)
//                ->limit(5)
//                ->all();
//
//
//            foreach($items as $item) {
//
//                $params1 = [
//                    'count_room' => $item['count_room'],
//                    //'phone' => '%0930043890%',
//                    'phone' => '%' . $item['phone'] . '%',
//                    'floor' => $item['floor']
//                ];
//                $params2 = [
//                    'phone' => '%' . $item['phone'] . '%',
//                    'floor' => $item['floor']
//                ];
//
//                $params3 = [
//                    'phone' => '%' . $item['phone'] . '%',
//                    'count_room' => $item['count_room']
//                ];
//                $params4 = [
//                    'phone' => '%' . $item['phone'] . '%',
//                ];
//
//                if ($this->setStatusPhone($params4)) {
//
//                }
//
//                if ($this->setNewStatusPhoneRooms($params3)) {
//
//                }
//
//                if ($this->setNewStatusPhoneFloor($params2)) {
//
//                }
//
//                if ($this->setNewStatusAllColumns($params1)) {
//
//                }
//            }
//
//            $start += 5;
//            echo $start;
//
//        }catch (Exception $exception)
//        {
//            $this->logDB("ID:$item->id, -- " . $exception->getMessage());
//        }
//
////        $params1 = [
////            'count_room' => 2,
////            'phone' => '%0930043890%',
////            'floor' => 5
////        ];
////
////        $params2 = [
////            'phone' => '%0930043890%',
////            'floor' => 5
////        ];
////
////        $params3 = [
////            'phone' => '%0930043890%',
////            'count_room' => 5
////        ];
////
////        $params4 = [
////            'phone' => '%0930043890%'
////        ];
//
//
//
//
//    }


//        $data = Yii::$app->db->createCommand(
//            "SELECT id
//                  FROM `parsercd`
//                  WHERE phone LIKE :phone AND
//                  count_room = :count_room AND
//                  floor = :floor")
//        ->bindValues($params)
//        ->queryAll();
//
//
//        if($data) {
//            $this->setNewStatus($data, $statuses['room_phone_floor']);
//        }


//        $items = (new \yii\db\Query())
//            ->select(['id'])
//            ->from('parsercd')
//            //���������� ���������
//            ->where('phone LIKE :phone', ['phone' => '%0930043890%'])
//            ->andWhere('count_room = :count_rooms', ['count_rooms' => 2])
//            ->andWhere('floor = :floor', ['floor' => 5])
//            ->offset($start)
//            ->all();
//
//
//        var_dump($items);
//





//        foreach ($items as $item) {
//            $item['phone'];
//            $similarPhonesCount = Yii::$app->db->createCommand(
//                "SELECT COUNT(*) FROM `apartment` WHERE ({$sql})")->queryScalar();
//
//
//        }



    public function actionCompareitems($start = 0)
    {
        try {
            /** @var Parsercd[] $items */
            //$items = Yii::$app->db->createCommand("SELECT * FROM parsercd ORDER BY id desc LIMIT $start, 10")
            //    ->queryAll();
            $items = Parsercd::find()->where(["!=", "enabled", 0])->orderBy('id')->offset($start)->limit(5)->all();

            foreach ($items as $item) {
				$similar = Parsercd::find()
					->where(["=", "floor", $item->floor])
					->andWhere(["=", "floor_all", $item->floor_all])
					->andWhere(["=", "phone", $item->phone])
					->andWhere(["=", "count_room", $item->count_room])
					->andWhere(["!=", "id", $item->id])
					->andWhere(["!=", "enabled", 0])
					->all();
				if($similar) {
					foreach($similar as $sim) {
						$sim->enabled = 0;
						$sim->save();
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

                $update_enabled = function ($value) use ($item) {
                    Yii::$app->db->createCommand("UPDATE `parsercd` SET
                    `enabled` = {$value} WHERE id = {$item->id}")->execute();
                };

                $numbers = self::normalizePhoneNumbersField($item->phone);
                $sql = '';
                if(!empty($numbers))
                {
                    foreach ($numbers as $n => $number) {
                        // ������ �����
                        if ($n === 0) {
                            $sql .= '`phone` LIKE "%' . $number . '%"';
                        } else {
                            $sql .= ' OR `phone` LIKE "%' . $number . '%"';
                        }
                    }
                    // $similarPhonesCount ���������� ������� ������� � ������ ��������
                    // ���������� ���� �������
                    $similarPhonesCount = Yii::$app->db->createCommand(
                        "SELECT COUNT(*) FROM `apartment` WHERE ({$sql})")->queryScalar();

                    // `���� ��������� ������� - �� �������� ���� �������� �������� "2"`
                    if ($similarPhonesCount > 0) {
                        $update_status(2);
                        $update_counter($similarPhonesCount);
                    }
                }else{
                    $sql = '1';
                }

                if(!$item->count_room) $item->count_room = 0;
                // $similarPhonesAndRoomsCount ���������� ������� ������� � ������ �������� + �-�� ������
                // ���������� ���� �������
                $similarPhonesAndRoomsCount = Yii::$app->db->createCommand(
                    "SELECT COUNT(*) FROM `apartment` WHERE ({$sql}) AND count_room = {$item->count_room}")->queryScalar();

                // `���� ��������� ������� � ���-�� ������ - �������� �������� "3"`
                if ($similarPhonesAndRoomsCount > 0) {
                    $update_status(3);
                    $update_counter($similarPhonesAndRoomsCount);
                }

                // $similarPhonesAndRoomsAndFloorsCount ���������� ������� ������� � ������ �������� + �-�� ������ + ���������
                // ���������� ���� �������
                if(!$item->floor_all) $item->floor_all= 0;
                $similarPhonesAndRoomsAndFloorsCount = Yii::$app->db->createCommand(
                    "SELECT COUNT(*) FROM `apartment` WHERE ({$sql}) AND count_room = {$item->count_room}
                  AND floor_all = {$item->floor_all}")->queryScalar();

                // `���� ��������� �������, ���-�� ������ � ���-�� ������ - �������� �������� "4" `
                if ($similarPhonesAndRoomsAndFloorsCount > 0) {
                    $update_status(4);
                    $update_counter($similarPhonesAndRoomsAndFloorsCount);
                }

                // $similarPhonesAndRoomsAndFloorsCount ���������� ������� ������� � ������ �������� + �-�� ������ + ���������
                // ���������� ���� �������
                if(!$item->floor) $item->floor = 0;
                $similarPhonesAndRoomsAndFloorsAndFloorCount = Yii::$app->db->createCommand(
                    "SELECT COUNT(*) FROM `apartment` WHERE ({$sql}) AND count_room = {$item->count_room}
                  AND floor_all = {$item->floor_all} AND floor = {$item->floor}")->queryScalar();

                // `� ������� ���� ��������� ��������� �������, ���-�� ������ � ���-�� ������ � ��������� ���� - �������� �������� "5".`
                if ($similarPhonesAndRoomsAndFloorsAndFloorCount > 0) {
                    //$update_status(5);
                    $update_enabled(0);
                    $update_counter($similarPhonesAndRoomsAndFloorsAndFloorCount);
                    $this->logDB("ID:$item->id, -- was delete");
                }
				//echo "finished";die;

            }

            $start += 5;
            echo $start;
        }catch (Exception $exception)
        {
            $this->logDB("ID:$item->id, -- " . $exception->getMessage());
        }
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
            // ������ �����
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
                  AND floor_all = {$item->floor_all}";
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
	public function actionDeleteitems()
	{
		Parsercd::deleteAll(["enabled" => 0]);
		echo "items was deleted!";
	}

    private function logDB($value)
    {
        $model = new ParsercdLog();
        switch (gettype($value)) {
            case "array":
                {
                    $model->text = join(",", $value);
                }
                break;
            default:
                $model->text = $value;
        }

        $model->save();
    }
}
