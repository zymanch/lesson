<?php
/**
 * Created by PhpStorm.
 * User: s4urp
 * Date: 04.06.2019
 * Time: 9:44
 */

namespace app\widgets;

class Chart extends \yii\bootstrap\Widget
{
    public $name = '';
    public $type = '"bar"';
    public $data = [];
    public $width = 300;
    public $height = 200;
    public $backgroundColor = '"rgba(75, 192, 192, 0.2)"';
    public $borderColor = '"rgba(75, 192, 192, 1)"';
    
    public function run()
    {
        $id = 'chart_' . md5(uniqid(rand(1, 99999), true));
        $labels = $dataset = [];
        foreach ($this->data as $row) {
            $labels[] = "'" . $row['x'] . "'";
            $dataset[] = $row['y'];
        }
        
        echo $this->render('//widgets/chart', [
            'id'              => $id,
            'name'            => $this->name,
            'width'           => $this->width,
            'height'          => $this->height,
            'type'            => $this->type,
            'labels'          => $labels,
            'dataset'         => $dataset,
            'backgroundColor' => $this->backgroundColor,
            'borderColor'     => $this->borderColor,
        ]);
    }
    
}