<?php
/**
 * Created by PhpStorm.
 * User: s4urp
 * Date: 11.06.2019
 * Time: 14:34
 */

namespace widgets;

use yii\bootstrap\Widget;

class CheckboxButtons extends Widget
{
    public $name = '';
    public $value = '';
    public $items = [];
    
    public function run()
    {
        echo $this->render('//widgets/form/checkboxButtons', [
            'name'  => $this->name,
            'value' => $this->value,
            'items' => $this->items,
        ]);
    }
}