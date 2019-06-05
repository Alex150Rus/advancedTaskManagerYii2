<?php

use \yii\db\AfterSaveEvent;

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

//навесили глобальный обработчик на все классы, отнаследованные от AR на событиу afterUpdate
yii\base\Event::on(\yii\db\ActiveRecord::class, \yii\db\ActiveRecord::EVENT_AFTER_UPDATE, function (AfterSaveEvent $event) {
    return Yii::info(
        \yii\db\ActiveRecord::EVENT_AFTER_UPDATE .
        json_encode($event->changedAttributes), 'ar');
});
