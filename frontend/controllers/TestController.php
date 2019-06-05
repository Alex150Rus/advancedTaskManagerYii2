<?php
namespace frontend\controllers;

use common\models\User;
use yii\web\Controller;

/**
 * Test controller
 */
class TestController extends Controller{

    public function actionIndex()
    {
        $model = User::findOne(1);
	    $model->password_reset_token = 1235;
	    $model->save();
	    return 'test';
    }
}
