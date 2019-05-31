<?php


namespace frontend\modules\api\controllers;


use frontend\modules\api\models\Project;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class ProjectController extends ActiveController
{
public $modelClass = Project::class;

    public function behaviors()
    {
        $behaviours = parent::behaviors();
        $behaviours['authenticator'] = [

          'class' => HttpBasicAuth::class,
          // 'class' => HttpBearerAuth::class,
          //  'class' => QueryParamAuth::class,
        ];
        return $behaviours;
    }
}