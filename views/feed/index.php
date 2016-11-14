<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FeedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Feedreader';
?>

<div class="feed-index">

    <p>
        <?php if ($dataProvider->count):  ?>
          <?= Html::a('Add manually feed', ['create', 'cateId' => $cateId], [
              'class' => 'btn btn-primary',
              'role'=>'modal-remote',
              'data-toggle'=>'tooltip'
          ]) ?>
        <?php endif; ?>

        <?php if ($cateId):  ?>
          <?php echo Html::a('Unsubscribe', ['unsubscribe', 'id' => $searchModel->category_id], [
              'class' => 'btn btn-warning',
              'data' => [
                  'confirm' => 'Are you sure want to unsubscribe this feed?',
                  'method' => 'post',
              ],
          ]) ?>
        <?php endif; ?>
    </p>

    <?php Pjax::begin(['id' => 'feed-listview-pjax']); ?>
      <?= ListView::widget([
          'dataProvider' => $dataProvider,
          'emptyText' => 'No Feed available.',
          'itemOptions' => ['class' => 'item'],
          'itemView' => '_item',
          'options' => ['style' => 'margin-top:25px']
      ]) ?>
    <?php Pjax::end(); ?>

</div>
