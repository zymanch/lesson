<?php

namespace controllers;

use components\Controller;
use yii\filters\AccessControl;

/**
 * Class ErrorController
 *
 * @package controllers
 */
class ErrorController extends Controller
{
    
    public $layout = 'login';

    /**
     * @return array|string[]
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'index',
                        ],
                        'allow'   => true,
                    ],
                ],
            ],
        ]);
    }

    /**
     * @return array|\string[][]
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    
}
