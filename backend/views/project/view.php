<?php

use common\models\Project;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $dataProvider common\models\Project*/

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

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
            'title',
            'description:ntext',
            [
              'attribute' => 'active',
               'value' => function ($dataProvider) {
                   return \yii\helpers\ArrayHelper::getValue(\common\models\Project::STATUS_LABELS, $dataProvider->active);
               },
            ],
            'creator_id',
            'updater_id',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
              'attribute' => 'user_id',
              'label' => 'username',
              'format' => 'raw',
              'value' => function ($dataProvider) {
                return Html::a(\common\models\User::findOne(
                  $dataProvider->user_id)->username, ['user/view', 'id' => $dataProvider->user_id]
                );
              }
            ],
            [
              'attribute' => 'role'
            ],
        ],
    ])?>

</div>
