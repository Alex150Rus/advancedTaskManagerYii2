<?php


namespace frontend\modules\api\controllers;


use yii\rest\ActiveController;
use frontend\modules\api\models\User;

class UserController extends ActiveController
{
public $modelClass = User::class;
}