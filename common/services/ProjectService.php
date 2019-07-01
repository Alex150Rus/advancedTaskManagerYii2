<?php

namespace common\services;

use common\models\Project;
use common\models\User;
use yii\base\Component;

use yii\base\Event;

/**
 * создаём класс информации о событии. Когда создаётся какое-то событие, можно предоставить дополнительную информацию
 * (которая распространяется в виде класса)всем подписчикам на это событие.
 * В Yii фрэймворке принято, что класс информации о событии располагается в файле класса, в котором событие возникает.
 * В данном случае это оправданно так как наше событие не будет использоваться отдельно от нашего класса ProjectService.
 * Но это не правило, которое нельзя нарушать. Более правильно делать классы информации о событии в отдельном классе
 * в папке services или в папке common, создав отдельную папочку events.
 * Class AssignRoleEvent
 * @property Project $project
 * @property string $user
 * @property string $role
 * @package common\services
 */
class AssignRoleEvent extends Event
{
    public $project;
    public $user;
    public $role;

    /**
     * сделан для удобства, чтобы одним методом получить всю информацию
     * @return array
     */
    public function dump(){
        return ['project' => $this->project->id, 'user' => $this->user->id, 'role' => $this->role];
    }
}

/**
 * наследуемся от Component, чтобы можно было использовать в поведениях и системе событий
 * Class ProjectService
 * @package common\services
 */
class ProjectService extends Component
{
    const EVENT_ASSIGN_ROLE = 'event_assign_role';

    /**
     * В этом методе мы создаём событие и триггерим его.
     * @param Project $project
     * @param User $user
     * @param $role
     */
    public function assignRole(Project $project, User $user, $role){
        $event = new AssignRoleEvent();
        $event->project = $project;
        $event->user = $user;
        $event->role = $role;
        $this->trigger(self::EVENT_ASSIGN_ROLE, $event);
    }

    public function getRoles(Project $project, User $user) {
        return $project->getProjectUsers()->byUser($user->id)->select('role')->column();
    }

    public function hasRole(Project $project, User $user, $role) {
        return in_array($role, $this->getRoles($project, $user));
    }

}