<?php

use yii\db\Migration;

/**
 * Handles the creation of table `new_parser_olx_params`.
 */
class m170306_113009_create_new_parser_olx_params_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->execute(file_get_contents(__DIR__ . '/params.sql'), []);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('new_parser_olx_params');
    }
}
