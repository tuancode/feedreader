<?php
use app\models\Category;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\redactor\widgets\Redactor;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Feed */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="feed-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'title')->textInput(['maxlength' => true])?>

  <?= $form->field($model, 'description')->widget(Redactor::className())?>

  <?= $form->field($model, 'link')->textInput(['maxlength' => true])?>

  <?= $form->field($model, 'category_id')->widget(Select2::className(), [
    'data' => ArrayHelper::map(Category::find()->all(), 'id', 'title'),
    'options' => ['placeholder' => 'Select a category ...'],
    'pluginOptions' => ['allowClear' => true],
  ]) ?>

  <?= $form->field($model, 'formattedPubDate')->widget(DatePicker::className(),[
      'convertFormat' => true,
      'removeButton' => false,
      'pluginOptions' => [
          'todayHighlight' => true,
          'todayBtn' => true,
          'autoclose'=>true,
          'todayHighlight' => true
      ]
  ])->label('Pub Day') ?>

  <?php if (!Yii::$app->request->isAjax){ ?>
    <div class="form-group">
      <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
    </div>
  <?php } ?>

  <?php ActiveForm::end(); ?>

</div>
