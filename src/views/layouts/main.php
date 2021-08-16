<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use app\widgets\InspiniaNav;
use assets\AppAsset;
use extensions\yii\helpers\Html;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?= $this->render('//layouts/_favicon'); ?>
    <?php $this->head() ?>
</head>
<body class="md-skin top-navigation">
<?php $this->beginBody() ?>

<div id="wrapper">
    
    <?php $menuItems = require(Yii::getAlias('@backend/views/mainMenu.php')); ?>

    <div id="page-wrapper" class="gray-bg">
        <div class="row">
            <nav class="navbar navbar-static-top" role="navigation">
                <div class="navbar-header">
                    <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse"
                            class="navbar-toggle collapsed" type="button">
                        <i class="fa fa-reorder"></i>
                    </button>
                    <a href="/" class="navbar-brand">УРОКИ</a>
                </div>
                <div class="navbar-collapse collapse" id="navbar">
                    <?php $menuItems = require(Yii::getAlias('@backend/views/mainMenu.php')); ?>
                    <?php echo InspiniaNav::widget([
                                                       'options'       => ['class' => 'nav navbar-nav'],
                                                       'items'         => $menuItems,
                                                       'dropDownCaret' => '',
                                                   ]);
                    ?>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <strong class="font-bold"
                                    id="username"><?= Yii::$app->user->identity->username ?></strong>
                        </li>
                        <li>
                            <a href="/profile/logout">
                                <i class="fa fa-sign-out"></i> Выход
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="wrapper wrapper-content">
            <?php
            echo Alert::widget();
            ?>
            <?= $content ?>
        </div>
        <div class="footer">
            <div class="col-md-4">
                <span>&copy; <?= date("Y") ?> Планирвоание Уроков</span>
            </div>
            <div class="col-md-4">
                <a href="#">Условия пользования</a>
            </div>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
