<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $password
 * @property string $email
 * @property string $photo
 * @property string $phone
 * @property integer $country
 * @property integer $region
 * @property integer $city
 * @property string $address
 * @property integer $user_group
 * @property integer $joined
 * @property integer $birth
 * @property integer $enabled
 * @property integer $last_login
 * @property integer $adm_last_login
 * @property string $confirm
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'password', 'email', 'photo', 'phone', 'country', 'region', 'city', 'address', 'user_group', 'joined', 'birth', 'last_login', 'adm_last_login', 'confirm'], 'required'],
            [['name', 'description', 'address'], 'string'],
            [['country', 'region', 'city', 'user_group', 'joined', 'birth', 'enabled', 'last_login', 'adm_last_login'], 'integer'],
            [['password', 'email', 'photo', 'phone', 'confirm'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
            'photo' => Yii::t('app', 'Photo'),
            'phone' => Yii::t('app', 'Phone'),
            'country' => Yii::t('app', 'Country'),
            'region' => Yii::t('app', 'Region'),
            'city' => Yii::t('app', 'City'),
            'address' => Yii::t('app', 'Address'),
            'user_group' => Yii::t('app', 'User Group'),
            'joined' => Yii::t('app', 'Joined'),
            'birth' => Yii::t('app', 'Birth'),
            'enabled' => Yii::t('app', 'Enabled'),
            'last_login' => Yii::t('app', 'Last Login'),
            'adm_last_login' => Yii::t('app', 'Adm Last Login'),
            'confirm' => Yii::t('app', 'Confirm'),
        ];
    }
}
