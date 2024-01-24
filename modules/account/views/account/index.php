<?php

use app\models\Application;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\modules\account\models\AccountSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Заявки';
?>
<div class="application-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать заявку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php echo $this->render('_search', ['model' => $searchModel, 'status' => $status, 'category' => $category]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{pager}\n<div class='d-flex flex-wrap'>{items}</div>\n{pager}",
        'itemOptions' => ['class' => 'item'],
        'itemView' => 'item',
        'pager' => [
            'class' => LinkPager::class,
            'linkOptions' => ['class' => 'page-link']
        ]
    ]) ?>

    <?php Pjax::end(); ?>

</div>
