<?php


namespace common\services;


use yii\base\Component;

/***
 * Class NotificationService
 * @package common\services
 */
class NotificationService extends Component
{
    protected $emailService;

    /**
     * NotificationService constructor.
     //* @param EmailInterface $emailService
     * @param array $config
     */
    public function __construct($emailService, $config = [])
    {
        parent::__construct($config);
        $this->emailService = $emailService;
    }

    /**
     * @param $user
     * @param $project
     * @param $role
     */
    public function sendAboutNewProjectRole($user, $project, $role){
        $views = ['html' => 'assignRoleToProject-html', 'text' => 'assignRoleToProject-text'];
        $data = ['user' => $user, 'project' => $project, 'role' => $role];
        $this->emailService->send($user->email, 'New role ' . $role, $views, $data);
    }
}