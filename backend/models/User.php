<?php

namespace backend\models;

use common\models\Project;
use common\models\Task;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property string $avatar
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property Task $activeTasks
 * @property Task $createdTasks
 * @property Task $updatedTasks
 * @property Project $createdProjects
 * @property Project $updatedProjects
 *
 * @const RELATION_TASKS_ACTIVE string activeTasks
 * @const RELATION_TASKS_CREATED string createdTasks
 * @const RELATION_TASKS_UPDATED string updatedTasks
 * @const RELATION_PROJECTS_CREATED string createdProjects
 * @const RELATION_PROJECTS_UPDATED string updatedProjects
 * @const RELATION_IN_PROJECTS string inProjects
 *
 * @const SCENARIO_UPDATE string $update
 * @const SCENARIO_INSERT string $insert
 *
 * @const AVATAR_PREVIEW string $preview
 * @const AVATAR_ICO string $ico
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
