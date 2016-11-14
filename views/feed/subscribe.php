<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Feed */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Subscribe new feed';
?>

<div class="feed-subscribe">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'address')->textarea(['maxlength' => true])
    ->hint('Use commas for multiple feeds subscrition.<br />
        Ex. http://www.feedforall.com/sample-feed.xml, http://www.feedforall.com/sample.xml') ?>

  <?php if (!Yii::$app->request->isAjax){ ?>
    <div class="form-group">
      <?= Html::submitButton('Subscribe', ['class' => 'btn btn-success', 'id' => 'btn-submit'])?>
    </div>
  <?php } ?>

  <?php ActiveForm::end(); ?>

</div>
