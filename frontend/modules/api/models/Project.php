<?php


namespace frontend\modules\api\models;


use yii\helpers\StringHelper;

class Project extends \common\models\Project
{
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['project_id' => 'id']);
    }

    public function fields() {
        return [
            'number' => 'id',
            'title' => 'title',
            'description_short' => function(){
                return StringHelper::truncate($this->description, 50);
            },
            'active' => 'active',
        ];
    }

    public function extraFields()
    {
        return [
            'tasks',
        ];
    }
}