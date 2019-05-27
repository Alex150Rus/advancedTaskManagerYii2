<?php

namespace common\modules\chat\widgets;

use yii\web\AssetBundle;



class ChatAsset extends AssetBundle
{
//    public $basePath = '@webroot';
//    public $baseUrl = '@web';

// указали из какой папки публиковать ресурсы в публичную папку web и какие ресурсы подключать.
    public $sourcePath = '@common/modules/chat/widgets/assets';
    public $css = [
        'css/chat.css',
    ];
    public $js = [
        'js/chat.js',
    ];
//    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
//    ];
}
