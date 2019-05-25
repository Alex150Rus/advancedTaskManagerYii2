<?php

namespace common\modules\chat\controllers;

use common\modules\chat\components\Chat;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use yii\console\Controller;

/**
 * Default controller for the `chat` module
 */
class DefaultController extends Controller
{
    public function actionIndex()
    {
        //создаётся экземпляр сервера, который будет работать на основе логики, созданной нами в папке components
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
            8080
        );
        echo 'Server start' . PHP_EOL;
        //метод запускает бесконечный цикл и внутри него постоянно проверяется не изменилось ли состояние нашего порта:
        //нет ли новых подключений, сообщений
        $server->run();
    }
}
