<?php

namespace app\modules\olxparser;

use Yii;

class olxParserHelper
{
    public static function tableExists($table)
    {
        $schema = Yii::$app->db->schema->getTableSchema($table);

        return $schema !== null;
    }
}