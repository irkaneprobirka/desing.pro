<?php

use app\models\Category;
use app\models\Status;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Application $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="application-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Назад', ['index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'status_id',
                'value' => fn($model) => Status::getStatus()[$model->status_id]
            ],
            [
                'attribute' => 'category_id',
                'value' => fn($model) => Category::getCategory()[$model->category_id]
            ],
            'title',
            'description',
            [
                'attribute' => 'image',
                'format' => 'html',
                'value' => fn($model) => Html::img('@web/img/' . $model->image, ['class' => 'w-50 h-50'])
            ],
            [
                'attribute' => 'image_admin',
                'format' => 'html',
                'visible' => (bool)$model->image_admin,
                'value' => fn($model) => Html::img('@web/img/' . $model->image_admin, ['class' => 'w-50 h-50'])
            ],
            [
                'attribute' => 'reason',
                'visible' => (bool)$model->reason,
            ],
            'created_at',
        ],
    ]) ?>

</div>
