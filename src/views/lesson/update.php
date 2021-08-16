<?php
/**
 * @var $this yii\web\View
 * @var $model \models\Lesson
 * @var $days \models\Day[]
 */

use extensions\yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Dashboard';
?>
<div class="site-index">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5 style="font-weight: bold"><?= $model->lessonType->name ?> <?=$model->class_number;?> класс</h5>
                </div>
                <div class="ibox-content">
                    <?php
                    $form = ActiveForm::begin([
                                                  'options' => [
                                                      'class' => 'form-horizontal',
                                                  ],
                                                  'layout'  => 'horizontal',
                                              ])
                    ?>
                    <table class="table">
                        <tr>
                            <td>&nbsp;</td>
                            <td>День</td>
                            <td>Раздел</td>
                            <td>Тема</td>
                            <td>Основные виды учебной деятельности</td>
                            <td>Коррекционные задачи</td>
                        </tr>
                        <?php foreach ($days as $day):?>
                        <tr>
                            <td></td>
                            <td><?=date('d M',strtotime($day->day));?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php endforeach;?>
                    </table>

                    <div class="form-group">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
