<?php

namespace helper\gridview;

class ColumnAppendClassByAttribute
{
    public static function appendToColumns(array $columns)
    {
        return array_map(function ($column) {
            
            $column = self::forceArray($column);
            
            //cannot append additional class
            if (empty($column['attribute']) && empty($column['label'])) {
                return $column;
            }
            
            $additionalClass = self::getAdditionalClassName($column);
            
            $appends = [
                'headerOptions'  => 'th',
                'contentOptions' => 'td',
            ];
            
            foreach ($appends as $param => $appendix) {
                self::checkClassSubKeyExists($param, $column);
                $column[$param]['class'] .= ' ' . $additionalClass . '-' . $appendix;
            }
            
            return $column;
        }, $columns);
    }
    
    protected static function forceArray($column)
    {
        if (is_string($column)) {
            return [
                'attribute' => $column,
            ];
        }
        return $column;
    }
    
    protected static function getAdditionalClassName($column)
    {
        $className = empty($column['attribute'])
            ? $column['label']
            : $column['attribute'];
        return self::normalizeClassName($className);
    }
    
    protected static function normalizeClassName($label)
    {
        $label = strtolower($label);
        $label = preg_replace("#[\s\.]+#", '_', $label);
        return $label;
    }
    
    private static function checkClassSubKeyExists($param, &$column)
    {
        if (!array_key_exists($param, $column)) {
            $column[$param] = [];
        }
        if (!array_key_exists('class', $column[$param])) {
            $column[$param]['class'] = '';
        }
    }
    
}