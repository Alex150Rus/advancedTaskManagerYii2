<?php

namespace frontend\modules\api\models;



class Task extends \common\models\Task
{

    public function getExecutor()
    {
        return $this->hasOne(User::className(), ['id' => 'executor_id']);
    }

    public function fields() {
        return [
            'number' => 'id',
            'title' => 'title',
            'description_short' => function(){
                return substr($this->description, 0, 50);
            },
        ];
    }

    public function extraFields()
    {
        return [
            'executor',
            'project',
        ];
    }
}
