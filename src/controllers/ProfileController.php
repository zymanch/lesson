<?php

namespace controllers;

use components\session\behaviour\LogSession;
use models\forms\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Site controller
 */
class ProfileController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'clear-cookie'],
                        'allow'   => true,
                    ],
                    [
                        'actions' => ['logout', 'clear-cookie'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
        ]);
    }
    
    public function actionClearCookie()
    {
        while (ob_get_level()) {
            ob_get_clean();
        }
        $pastTime = time() - 360000;
        if (isset($_COOKIE) && is_array($_COOKIE)) {
            foreach ($_COOKIE as $name => $value) {
                setcookie($name, '', $pastTime);
                setrawcookie($name, '', $pastTime);
                setcookie($name, '', $pastTime, '/');
                setrawcookie($name, '', $pastTime, '/');
            }
        }
        
        setcookie(session_name(), '', $pastTime);
        setrawcookie(session_name(), '', $pastTime);
        setcookie(session_name(), '', $pastTime, '/');
        setrawcookie(session_name(), '', $pastTime, '/');
        
        if (isset($_SESSION) && is_array($_SESSION)) {
            foreach ($_SESSION as $name => $value) {
                unset($_SESSION[$name]);
            }
        }
        @session_unset();
        @session_destroy();
        die('Set default profile - ok');
    }
    
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $this->layout = 'login';
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        
        return $this->goHome();
    }
}
