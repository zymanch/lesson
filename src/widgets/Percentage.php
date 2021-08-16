<?php
/**
 * Created by PhpStorm.
 * User: s4urp
 * Date: 04.06.2019
 * Time: 9:44
 */

namespace app\widgets;

class Percentage extends \yii\bootstrap\Widget
{
    public $name = '';
    public $value = 0;
    
    public function run()
    {
        echo $this->render('//widgets/percentage', [
            'name'  => $this->name,
            'value' => $this->value,
        ]);
    }
}