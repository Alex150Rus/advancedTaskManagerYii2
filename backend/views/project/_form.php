<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->dropDownList(\common\models\Project::STATUS_LABELS) ?>

    <?php if(!$model->isNewRecord) {?>


    <?= $form->field($model, \common\models\Project::RELATION_PROJECT_USERS)->widget(\unclead\multipleinput\MultipleInput::className(), [
        /* https://github.com/unclead/yii2-multiple-input. В этом виджете нельзя использовать заглавные буквы. Только
         *  прописные
         * 'max' - количество строк
         * attribute выше - имя атрибута, к которому будем обращаться в контроллере в методе loadModel для записи в БД
        */
        'max' => 10,
        'min' => 0,
        'addButtonPosition' => \unclead\multipleinput\MultipleInput::POS_HEADER,
        'id' => 'project-users-widget',

        'columns' => [
            [
                'name'  => 'project_id',
                'type'  => 'hiddenInput',
                'defaultValue' => $model->id,
            ],
            [
                'name'  => 'user_id',
                'type'  => 'dropDownList',
                'title' => 'Юзер',
                // для наглядности в учебных целях. Логика должна быть в контроллере и прийти сюда в виде переменной
                'items' => \backend\models\User::find()->select('username')->indexBy('id')->column(),
            ],
            [
                'name'  => 'role',
                'type' => 'dropDownList',
                'title' => 'Роль',
                'items' => \common\models\ProjectUser::ROLE_LABELS,
            ]
        ]
    ]); ?>
    <?php }?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
