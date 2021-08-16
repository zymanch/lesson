<?php

namespace helper\gridview;

use extensions\yii\helpers\Html;
use Yii;
use yii\web\Request;

class CustomColumnHeader
{
    private $attribute;
    private $controller;
    private $action;
    private $sortField;
    
    public function __construct($attribute)
    {
        $this->attribute = $attribute;
        $request = Yii::$app->getRequest();
        $this->controller = Yii::$app->controller->id;
        $this->action = Yii::$app->controller->action->id;
        $this->sortField = $request->get('sort');
    }
  
    public function render()
    {
        return Html::a(ucwords($this->attribute),
                       $this->resolveSortLink(),
                       [
                           'class'     => $this->getSortClass(),
                           'data-sort' => $this->getSortSign() . $this->attribute,
                       ]);
    }
    
    private function isCurrentFieldSorting()
    {
        return trim($this->sortField, '-') == $this->attribute;
    }
    
    private function getSortClass()
    {
        if (!$this->isCurrentFieldSorting()) {
            return '';
        }
        if (substr($this->sortField, 0, 1) == '-') {
            return 'desc';
        }
        return 'asc';
    }
    
    private function getSortSign()
    {
        if (!$this->isCurrentFieldSorting()) {
            return '';
        }
        if (substr($this->sortField, 0, 1) == '-') {
            return '';
        }
        return '-';
    }
    
    private function resolveSortLink()
    {
        /** @var Request $request */
        
        $path = '/' . $this->controller . '/' . $this->action;
        
        return $path . '?sort=' . $this->getSortSign() . $this->attribute;
    }
}