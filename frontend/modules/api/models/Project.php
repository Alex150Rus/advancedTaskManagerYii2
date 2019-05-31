<?php


namespace frontend\modules\api\models;


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
                return substr($this->description, 0, 50);
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