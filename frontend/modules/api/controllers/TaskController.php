<?php

namespace frontend\modules\api\controllers;

use frontend\modules\api\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use frontend\modules\api\models\Task;
use yii\rest\Controller;

class TaskController extends Controller
{
    //public $modelClass = Task::class;

//    public function behaviors()
//    {
//        $behaviours = parent::behaviors();
//        $behaviours['authenticator'] = [
//
//          'class' => HttpBasicAuth::class,
//          // 'class' => HttpBearerAuth::class,
//          //  'class' => QueryParamAuth::class,
//        ];
//        return $behaviours;
//    }

    // нижний блок работает, если наследуемся от Controller

    public function actionIndex(){

        //а теперь с пагинацией
        $dp = new ActiveDataProvider([
            'query' => Task::find()
        ]);
        $dp->pagination->pageSize=1;
        return $dp;

//        return new ActiveDataProvider([
//           'query' => Task::find()
//        ]);
    }

    public function actionView($id) {
        return Task::findOne($id);
    }

}