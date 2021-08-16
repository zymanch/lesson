<?php
/**
 * Created by PhpStorm.
 * User: s4urp
 * Date: 11.06.2019
 * Time: 14:34
 */

namespace widgets;

use yii\bootstrap\Widget;

class InputWithLabel extends Widget
{
    public $label = '';
    public $name = '';
    public $value = '';
    public $options = [];
    
    public function run()
    {
        echo $this->render('//widgets/form/inputWithLabel', [
            'label'   => $this->label,
            'name'    => $this->name,
            'value'   => $this->value,
            'options' => $this->options,
        ]);
    }
}