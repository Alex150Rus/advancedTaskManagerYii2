<?php

namespace backend\controllers;

use common\models\User;
use Yii;
use common\models\Project;
use common\models\search\ProjectSearch;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [

                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
// проверяем работу роли - это более тонкая настройка доступа экшонов пользователю
//        if (Yii::$app->user->can('admin')){
//            exit('admin');
//        }

        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Project model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $project = $this ->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => $project->getProjectUsers()
        ]);
        return $this->render('view', [
            'model' => $project,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('createProject')) {
            throw new ForbiddenHttpException();
        }

        $model = new Project();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        //получим старые роли до изменения данных
        $roles = $model->getUsersRoles();

        if ($this->loadModel($model) && $model->save()) {

            //после сохранения новых ролей сравним старый список с новым и запишем в переменную различие в ролях
            if ($diffRoles = array_diff_assoc($model->getUsersRoles(), $roles)) {
                foreach ($diffRoles as $userId => $diffRole) {
                    // отправляем данные в метод assignRole, который выполнит некие действия:
                    // нотификация пользователя по почте при смене роли
                    Yii::$app->projectService->assignRole($model, User::findOne($userId), $diffRole);
                }
            }


            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Project model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    private function loadModel (Project $model) {
        // используем метод пост для получения post данных. Получим массив Project[c ключами]
        // Project[projectUsers][цифра - номер строки][project_id или role] - атрибут name тэга select формы
        $data = Yii::$app->request->post($model->formName());
        //из массива получаем данные по нужному ключу
        $projectUsers = $data[Project::RELATION_PROJECT_USERS] ?? null;

        if ($projectUsers !== null) {
            // записать данные сможем так как установлен behavior saveRelations иначе только get
            $model->projectUsers = $projectUsers === '' ? [] : $projectUsers;
        }

        return $model->load(Yii::$app->request->post());
    }

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
