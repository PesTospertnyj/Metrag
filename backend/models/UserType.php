<?php

namespace backend\models;

use yii\db\ActiveRecord;

class UserType extends ActiveRecord
{
	public $author_id;
	public $update_author_id;
	public $update_photo_user_id;
	public $exclusive_user_id;
}

?>