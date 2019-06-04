<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="user-form">

    <?php $form = yii\bootstrap\ActiveForm::begin([
      // применяем, если в форме загружается файл
        'options' => ['enctype' => 'multipart/form-data'],
        'layout' => 'horizontal',
    ]); ?>

    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'password')->textInput() ?>
    <?= $form->field($model, 'status')->dropDownList(\backend\models\User::STATUS_LABELS) ?>

    <?= $form->field($model, 'avatar')
        ->fileInput(['accept' => 'image/*'])
        ->label(Html::img($model->getThumbUploadUrl('avatar', \common\models\User::AVATAR_ICO))) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success center-block', ]) ?>
    </div>

    <?php yii\bootstrap\ActiveForm::end(); ?>

</div>
