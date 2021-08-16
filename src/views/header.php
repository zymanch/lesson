<?php

use app\widgets\Alert;
use extensions\yii\helpers\Html;
use yii\widgets\Breadcrumbs;

?>

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-md-12">
            <?php if ($this->title) {
                echo Html::tag('h2', $this->title);
            } ?>
            <?= Breadcrumbs::widget([
                                        'activeItemTemplate' => "<li class=\"active\"><strong>{link}</strong></li>\n",
                                        'links'              => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                    ]) ?>
        </div>
    </div>
