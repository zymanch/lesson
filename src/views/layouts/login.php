<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 18.10.16
 * Time: 13:15
 * @var $this \yii\web\View
 */

use assets\AppAsset;
use extensions\yii\helpers\Html;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <link rel="stylesheet" href="/css/login.css">
    <title><?= Html::encode($this->title) ?></title>
    <?=$this->render('//layouts/_favicon');?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

