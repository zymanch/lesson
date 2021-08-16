<?php
/**
 * Created by PhpStorm.
 * User: s4urp
 * Date: 01.07.2019
 * Time: 15:21
 */

namespace widgets;

use yii\bootstrap\Widget;

class JsonEditor extends Widget
{
    protected $id = '';
    public $name;
    public $json = '{}';
    
    protected function generateId()
    {
        $this->id = '_' . md5(uniqid(rand(111, 999), true));
    }
    
    public function run()
    {
        $this->generateId();
        echo $this->render('//widgets/json-editor', [
            'id'   => $this->id,
            'name' => $this->name,
            'json' => $this->json,
        ]);
    }
}