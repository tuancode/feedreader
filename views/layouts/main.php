<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\models\Category;
use app\models\Feed;
use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\Nav;
use yii\helpers\StringHelper;

AppAsset::register($this);
CrudAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-3 sidebar">
        <p class="logo">Feedreader</p>
        <ul class="s-nav">
          <li class="cate-all"><?= Html::a('All items', ['index']) ?></li>
          <li class="cate-feed">
            <?php foreach (Category::find()->all() as $category): ?>
              <?= Html::a(
                  StringHelper::truncate(Html::encode($category->title), 25, '...'),
                  ['/feed', 'cateId' => $category->id],
                  ['class' => (Yii::$app->request->get('cateId') == $category->id) ? 'active' : '']
              ) ?>
            <?php endforeach; ?>
          </li>
        </ul>
        <p class="subscribe">
          <?= Html::a('Subscribe new feed', ['subscribe'], ['class' => 'btn btn-success']) ?>
        </p>
      </div>

      <div class="col-sm-9 col-sm-push-3">
        <div class="main"><?= $content ?></div>
      </div>
    </div>
  </div>

</div>

<footer class="footer">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-9 col-sm-push-3">
        <p class="pull-left">&copy; Tuan Vu <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
      </div>
    </div>
  </div>
</footer>

<?php Modal::begin([
    'id' => 'ajaxCrudModal',
    'footer' => '',// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
