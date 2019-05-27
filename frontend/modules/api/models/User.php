<?php
namespace frontend\modules\api\models;

class User extends \common\models\User
{
    public function fields()
    {
        return [
            'number' => 'id',
            'name' => 'username',
        ];
    }
}
