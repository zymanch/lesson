<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 24.10.16
 * Time: 17:08
 */

namespace extensions\yii\grid;

use Closure;
use extensions\yii\helpers\Html;
use yii\grid\CheckboxColumn as YiiGridCheckboxColumn;
use yii\helpers\Json;

class CheckboxColumn extends YiiGridCheckboxColumn
{

    public $cssClass = 'i-checks';
    public $header   = false;

    public function init()
    {
        parent::init();
        $this->registerICheckScript();
    }

    public function registerICheckScript()
    {
        $this->grid->getView()->registerJs(
            "$('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green'
                });",
            \yii\web\View::POS_READY,
            'iCheck');
    }

    protected function renderDataCellContent($model, $key, $index)
    {
        if ($this->checkboxOptions instanceof Closure) {
            $options = call_user_func($this->checkboxOptions, $model, $key, $index, $this);
        } else {
            $options = $this->checkboxOptions;
        }

        if (!isset($options['value'])) {
            $options['value'] = is_array($key) ? Json::encode($key) : $key;
        }

        if ($this->cssClass !== null) {
            Html::addCssClass($options, $this->cssClass);
        }

        $realCheckbox = Html::checkbox($this->name, !empty($options['checked']), $options);
        $fancyFakeCheckbox = Html::tag('ins', '', ['class' => 'iCheck-helper']);

        return Html::tag('div', $realCheckbox . $fancyFakeCheckbox, ['class' => 'icheckbox_square-green']);
    }

}

?>