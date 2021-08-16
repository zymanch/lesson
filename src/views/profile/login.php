<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model models\forms\LoginForm */

use extensions\yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Sheer.com - Uncover Yourself - (Brand Monetization and Promotion)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="header" class="clearfix">
    <!--    <a href="" class="trs fl pull-left">What is Sheer.com?</a>-->
    <!--    <a href="" class="trs btn btn-sheer pull-right shd">REGISTER NOW</a>-->
    <a href="/" class="logo"><img src="/img/sheer-ws.png" class="img-responsive"/></a>
</div>
<div class="container-fluid">
    <div class="box shd" id="login">
        <?php $form = ActiveForm::begin([
                                            'id'      => 'login-form',
                                            'options' => ['class' => 'm-t', 'role' => 'form'],
                                        ]); ?>
        <div class="form-group">
            <label for="username" class="sr-only">Имя</label>
            <?php echo $form->field($model, 'username')
                            ->textInput([
                                            'id'           => "username",
                                            'autofocus'    => false,
                                            'autocomplete' => 'Off',
                                            'class'        => 'form-control',
                                            'placeholder'  => 'Username',
                                            'required'     => 'required',
                                        ])
                            ->label(false); ?>
        </div>
        <div class="form-group">
            <label for="pwd" class="sr-only">Пароль</label>
            <?php echo $form->field($model, 'password')
                            ->passwordInput([
                                                'id'           => "pwd",
                                                'class'        => 'form-control',
                                                'autofocus'    => false,
                                                'autocomplete' => 'Off',
                                                'placeholder'  => 'Password',
                                                'required'     => 'required',
                                            ])
                            ->label(false); ?>
        </div>
        <div class="form-group">
            <?php echo $form->field($model, 'rememberMe')->checkbox(); ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Login', [
                'class' => 'trs btn btn-sheer',
                'name'  => 'login-button',
            ]) ?>
        </div>
        <!--        <div class="form-group">-->
        <!--            <a href="">Forgot your password?</a>-->
        <!--        </div>-->
        <?php ActiveForm::end(); ?>
    </div>
</div>