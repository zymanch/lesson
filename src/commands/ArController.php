<?php

namespace commands;

use yii\console\Controller;

class ArController extends Controller
{

    public $tables;

    public function options($actionID)
    {
        return ['tables'];
    }

    public function actionIndex()
    {
        if (!$this->tables) {
            $tables = [
                'lesson' => [
                    'day',
                    'lesson',
                    'lesson_day',
                    'lesson_type',
                    'user',
                    'year',
                    'theme',
                ],
            ];
            // not for all tables need AR
            $this->tables = collect($tables)->map(function ($items, $key) {
                return $key . ':' . implode(',', $items);
            })->implode(';');
        }

        $helper = new \ActiveGenerator\generator\ScriptHelper();
        $helper->baseClass = 'yii\db\ActiveRecord';
        $helper->queryBaseClass = 'yii\db\ActiveQuery';
        $helper->namespace = 'models';
        $helper->prefix = 'Base';
        $helper->sub = 'base';
        $helper->path = \Yii::getAlias('@app/models');
        $helper->generate(
            \Yii::$app->db->masterPdo,
            $this->tables
        );
    }
}
