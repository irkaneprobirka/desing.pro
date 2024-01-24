<?php

use app\models\Category;
use app\models\Status;
use yii\bootstrap5\Html;
?>

<div class="card mx-3 my-3" style="width: 18rem;">
<?= Html::img('@web/img/' . $model->image, ['style'  => 'height: 20rem'] ) ?>
  <div class="card-body">
    <h5 class="card-title">Название:<?= Html::encode($model->title)?></h5>
    <p class="card-text">Описание:<?= Html::encode($model->description)?></p>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Категория:<?= Html::encode(Category::getCategory()[$model->category_id])?></li>
    <li class="list-group-item">Статус:<?= Html::encode(Status::getStatus()[$model->status_id])?></li>
    <li class="list-group-item">Дата создания: <?= date('d.m.Y H:i:s',strtotime($model->created_at))?></li>
  </ul>
  <div class="card-body">
  <?= Html::a('Просмотр', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
  </div>
</div>