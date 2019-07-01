<?php


namespace common\services;

use yii\base\Component;

/**
 * отправляет почту
 * Class EmailService
 * @package common\services
 */
class EmailService extends Component
{
    /**
     * вызываем и настраиваем компонент mailer(настроен в main-local.php)
     * @param $to
     * @param $subject
     * @param $views
     * @param $data
     */
    public function send($to, $subject, $views, $data) {
        //всё что приведено ниже нет большой необходимости писать вручную, так как всё это мы можем взять во
        // @frontend/models/ContactForm или PasswordResetRequest. Фактически это конструктор письма
        \Yii::$app
            ->mailer
            //создаёт текст письма. Во $views должен быть массив из имён вьюх, на основе кторого будет создаваться html
            //и текстовые части письма. $data - данные для рендера вьюх. Похоже на рендер в контроллере
            ->compose($views, $data)
            // параметры берутся из common/config/params - от какого имэйла отправляется письмо и имя (мы используем
            //имя нашего приложения, но можно его вынести в параментры и брать оттуда)
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
            //кому - email
            ->setTo($to)
            ->setSubject($subject)
            ->send();
    }
}