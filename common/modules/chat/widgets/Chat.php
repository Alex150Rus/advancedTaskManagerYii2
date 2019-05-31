<?php
namespace common\modules\chat\widgets;

use common\modules\chat\widgets\ChatAsset;
use Yii;

class Chat extends \yii\bootstrap\Widget
{

    public $port = 8080;

    public function init()
    {

        //передаём вьюху в наш asset
        ChatAsset::register($this->view);

        $this->view->registerJsVar('wsPort', $this->port);
        $this->view->registerJsVar('websocketUser', Yii::$app->user->identity->username);

    }


    //выполняется когда виджет куда-то вставляем. Здесь должно быть содержимое content виджета.
    public function run()
    {
        //подключаемся ко вьюхе и регистрируем js файл, но это не совсем правильно. Для этого есть папка assets и
        // assets bundle
       // $this->view->registerJsFile('/js/chat.js');
        //как и в контроллере можно рендерить вьюхи
        return $this->render('chat');
    }
}
