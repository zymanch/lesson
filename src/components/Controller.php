<?php

namespace components;

use components\session\behaviour\LogSession;
use models\Director;
use models\User;
use Yii;

class Controller extends \yii\web\Controller
{
    public function behaviors()
    {
        return [

        ];
    }
    
    public function init()
    {
        $user = Yii::$app->user;
        if ($user->isGuest) {
            return $this->redirect('profile/login');
        }
    }
    
    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->getUser()->user_id;
    }
    
    /**
     * @return User
     */
    public function getUser()
    {
        return Yii::$app->user->identity;
    }

    
    protected function refreshRedirect($appendToUrl = "")
    {
        $currentController = Yii::$app->controller;
        $controller = $currentController->id;
        $action = $currentController->action->id;
        $url = '/' . $controller . '/' . $action;
        if (!empty($appendToUrl)) {
            $url = $url . $appendToUrl;
        }
        return $this->redirect($url);
    }
}
