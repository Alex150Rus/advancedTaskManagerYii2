<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'email:email',
            'avatar',
            [
                'attribute' => 'status',
                'value' => function($dataProvider) {
                    return \yii\helpers\ArrayHelper::getValue(\common\models\User::STATUS_LABELS, $dataProvider->status);
                },
            ],
            'created_at:datetime',
            'updated_at:datetime',
            'verification_token',
        ],
    ]) ?>

    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'title',
                'label' => 'Project title',
                'format' => 'raw',
                'value' => function ($dataProvider) {
                    return Html::a(
                      \common\models\Project::findOne(
                        $dataProvider->project_id)->title, ['project/view', 'id' => $dataProvider->project_id]
                    );
                }
            ],
            [
                'attribute' => 'role',
            ],
        ],
    ])?>

</div>
