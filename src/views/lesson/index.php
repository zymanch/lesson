<?php
/**
 * @var   $this         yii\web\View
 * @var   $lessons  \models\Lesson[]
 */

use controllers\StatController;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Dashboard';
?>
<div class="site-index">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5 style="font-weight: bold">Список ваших уроков</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table">
                        <?php $lastYear = null; ?>
                        <?php foreach ($lessons as $lesson):?>
                            <?php if ($lastYear !== $lesson->year_id):?>
                            <tr>
                                <td colspan="2"><h2><?=$lesson->year->name;?></h2></td>
                            </tr>
                            <tr>
                                <td width="100px">Класс</td>
                                <td>Урок</td>
                                <td width="100px">&nbsp;</td>
                            </tr>
                            <?php $lastYear = $lesson->year_id;?>
                            <?php endif;?>
                            <tr>
                                <td>
                                    <?=$lesson->class_number;?>
                                </td>
                                <td>
                                    <?=Html::a($lesson->lessonType->name,['lesson/update','id'=>$lesson->lesson_id]);?>
                                </td>
                                <td>
                                    <?=Html::a('<i class="fa fa-edit"></i>',['lesson/update','id'=>$lesson->lesson_id]);?>
                                    <?=Html::a('<i class="fa fa-server"></i>',['theme/update','id'=>$lesson->lesson_id]);?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
