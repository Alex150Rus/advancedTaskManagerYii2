<?php

namespace backend\models;

/**
 * @property string $password
*/
class User extends \common\models\User
{
    private $password;

    public function rules()
    {
        return [
            [['email', 'username'], 'required'],
            [['avatar'], 'default', 'value' => 'avatar'],
            [['username', 'email', 'auth_key', 'password'], 'safe'],
            ['status', 'in', 'range' => self::STATUSES],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            // применяем валидатор image. Ещё здесь можно было бы применить валидатор file для ограничени размера файла
            ['avatar', 'image', 'extensions' => 'jpg, jpeg, gif, png', 'on' => [self::SCENARIO_UPDATE]],
        ];
    }

    public function setPassword($password)
    {
        $this->password = $password;
        if($password) {
            parent::setPassword($password);
        }
    }

    public function getPassword() {
        return $this->password;
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)){
            return false;
        }

        if($insert) {
            $this->generateAuthKey();
        }
        return true;
    }
}
