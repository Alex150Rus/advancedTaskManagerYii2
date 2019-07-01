<?php


namespace console\controllers;


use common\models\Project;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = \Yii::$app->authManager;

        // добавляем разрешение "createPost"
        $createProject = $auth->createPermission('createProject');
        $createProject->description = 'Create project';
        $auth->add($createProject);
//
//        // добавляем разрешение "updatePost"
//        $updatePost = $auth->createPermission('updatePost');
//        $updatePost->description = 'Update post';
//        $auth->add($updatePost);

        // добавляем роль "author" и даём роли разрешение "createPost"
        $user = $auth->createRole('user');
        $auth->add($user);
//        $auth->addChild($author, $createPost);

        // добавляем роль "admin" и даём роли разрешение "updatePost"
        // а также все разрешения роли "author"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $createProject);
        $auth->addChild($admin, $user);

        // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
        // обычно реализуемый в модели User.

        //$auth->assign($admin, 1);
        $auth->assign($admin, 1);
        $auth->assign($user, 2);
        $auth->assign($user, 3);
    }
}