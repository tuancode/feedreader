<?php
use yii\bootstrap\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\StringHelper;

/* @var $model app\models\Feed */
?>

<div class="row">
  <div class="item-title col-sm-9">
    <?= Html::a($model->title, $model->link, ['target' => '_blank']) ?>
    <span class="pub-date"><?= Yii::$app->formatter->asDate($model->pubDate) ?></span>
  </div>
  <div class="col-sm-3">
    <span class="item-actions">
      <?= Html::a(Html::icon('edit'), ['update', 'id' => $model->id], [
          'title' => 'Edit',
          'role' => 'modal-remote',
          'data-toggle' => 'tooltip'
      ]) ?>
      <?= Html::a(Html::icon('trash'), ['delete', 'id' => $model->id], [
          'title' => 'Delete',
          'role' => 'modal-remote',
          'data-toggle' => 'tooltip',
          'data-request-method' => 'post',
          'data-confirm-title' => 'Are you sure?',
          'data-confirm-message' => 'Are you sure want to delete this item'
      ]) ?>
    </span>
  </div>
</div>

<div class="row">
  <div class="col-sm-3">
    <span class="item-source"><?= StringHelper::truncate(Html::encode($model->category->title), 25, '...') ?></span>
  </div>
</div>

<div class="row">
  <div class="item-description col-sm-12">
    <?= HtmlPurifier::process($model->description) ?>
  </div>
</div>
