<?php
/**
 * @var $this yii\web\View
 * @var $model \models\Lesson
 * @var $days \models\Day[]
 */

use extensions\yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Разделы';
$this->registerJs('
$("#add-new-row").click(function(e) {
    e.stopPropagation();
    var $tr = $(this).parents("tr"),
        blank = "<tr>"+$("#row-blank").html()+"</tr>";
    $tr.before(blank);
    return false;
});
$("#theme-list tr").sortable({
    appendTo: document.body
});
');
?>
<div class="site-index">
    <div class="row">
        <div class="col-md-6 col-md-push-3">
            <div class="ibox">
                <div class="ibox-title">
                    <h5 style="font-weight: bold">Разделы <?= $model->lessonType->name ?> <?=$model->class_number;?> класс</h5>
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
                    <div  id="theme-list">
                        <?php foreach ($model->themes as $theme):?>
                        <tr>
                            <td style="width: 10px"><i class="fa fa-bars"></i></td>
                            <td class="form-group">
                                <?= Html::hiddenInput('theme[id][]', $theme->theme_id) ?>
                                <?= Html::textInput('theme[name][]', $theme->name,['class'=>'form-control']) ?>
                            </td>
                        </tr>
                        <?php endforeach;?>
                        <tr>
                            <td class="text-center"><button class="btn btn-primary" id="add-new-row"><i class="fa fa-plus"></i></button></td>
                        </tr>
                        <tr style="display: none" id="row-blank">
                            <td style="width: 10px"><i class="fa fa-bars"></i></td>
                            <td class="form-group">
                                <?= Html::textInput('theme[name][]', '',['class'=>'form-control','placeholder'=>'Новый раздел']) ?>
                            </td>
                        </tr>
                    </div>

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
