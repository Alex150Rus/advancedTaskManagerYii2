<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            //по умолчанию другой путь стоит. Мы его здесь меняем
            'itemFile' => '@console/rbac/items.php',
            'assignmentFile' => '@console/rbac/assignments.php',
        ],
        'emailService' => [
            'class' => \common\services\EmailService::class,
        ],
        'projectService' => [
            'class' => \common\services\ProjectService::class,
            // делаем подписку на событие on с пробелом, событие, обработчик - анонимная функция
            'on ' . \common\services\ProjectService::EVENT_ASSIGN_ROLE =>
                function(\common\services\AssignRoleEvent $e){
                    /** мы могли бы здесь реализовать отправку почты, но в конфиге желательно не делать никакой логики.
                    * в принципе, анонимная функция - это уже некоторая логика и некоторый код, которые излишни в конфиге.
                    * Поэтому, по крайней мере, в самой функции никакой логики, тем более бизнес логики не должно быть.
                    * Максимум - можно вызвать какой-нибудь метод из другого сервиса*/

                    /**формируем массив вьюх. Наглядный пример -@frontend/models/SignupForm. Там в compose - список вьюх.
                     *у нас получается здесь много кода, которого не должно быть. Мы его уберём на следующем уроке.
                     *Сами вьюхи делаются в common/mail.
                     *Сейчас очень важно делать письма, содержащие две части: text и html - спам фильтр считает письмо
                     *более благонадёжным, когда оно содержит обе части.*/

                    $views = ['html' => 'assignRole-html', 'text' => 'assignRole-text'];
                    $data = ['user' => $e->user, 'project' => $e->project, 'role' => $e->role];

                    /** вызываем наш e-mail сервис, который предваритеьно нужно прописать выше. Чтобы шторм видел вновь
                     * созданные сервисы нужно подложить в проект псевдокласс yii\web\Application. Создадим папку ide
                     * в корне проекта. Ниже - subject придумываем сами
                     * После отправки письмо увидим в дебаг панели-раздел mail по пост запросу ищем или в папке runtime*/
                    Yii::$app->emailService->send($e->user->email, 'Assign role', $views, $data);
                    //Yii::$app->notificationService->sendAboutNewProjectRole($e->user, $e->project, $e->role);
                },
        ]
    ],
    'modules' => [
        // id нашего модуля из Gii
        'chat' => [
            'class' => 'common\modules\chat\Module',
        ],
    ],
];
