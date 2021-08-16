<?php

/* @var $this yii\web\View */

use extensions\yii\helpers\Html;

/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div id="header" class="clearfix">
    <a href="/" class="logo"><img src="/img/sheer-ws.png" class="img-responsive"/></a>
</div>
<div class="container-fluid text-center">
    <div class="
                col-lg-2 col-lg-offset-5
                col-md-4 col-md-offset-4
                col-sm-6 col-sm-offset-3">

        <div class="site-error">

            <div class="form-group">

                <h1>Sorry, some error occurs</h1>

                <div class="alert alert-danger">
                    <?= nl2br(Html::encode($message)) ?>
                </div>
            </div>

            <div class="form-group">
                <a class="trs btn btn-sheer" href="/">Return to main page</a>
            </div>

        </div>
    </div>
</div>
<footer class="footer">
    <div class="container-fluid">
        <p class="text-muted">&copy; Sheer.com </p>
    </div>
</footer>

