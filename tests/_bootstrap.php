<?php
define('YII_ENV', 'test');
defined('YII_DEBUG') or define('YII_DEBUG', true);

require_once __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../vendor/autoload.php';

class Tester
{
    const TEST_USER = "tarasov";
    const TEST_PASS = "123";
    const TEST_URL = "http://sheer";

    public static function fillOnlyfans()
    {
        $user = self::getUser();
        $user->setSetting(\models\forms\settings\IntegrationsForm::SETTING_KEY_ONLYFANS, Tester::TEST_USER);
        $user->save(false, ['json_params']);
    }

    /**
     * @return \models\User
     */
    public static function getUser()
    {
        return \models\UserQuery::model()->filterByUsername(self::TEST_USER)->one();
    }

    public static function getUserId()
    {
        return self::getUser()->user_id;
    }

    public static function getUploadsCount()
    {
        return \models\UploadsQuery::model()->count();
    }

    public static function getProtectedUrls()
    {
        return [
            self::getUrl("/"),
            self::getUrl("/terms"),
            self::getUrl("/stat/index"),
            self::getUrl("/upload/index"),
            self::getUrl("/payment/index"),
            self::getUrl("/settings/index"),
        ];
    }

    public static function getUrl($path)
    {
        return self::TEST_URL . $path;
    }

    public static function getResetProfileUrl()
    {
        return self::getUrl("/settings/set-default");
    }

    public static function getLogoutUrl()
    {
        return self::getUrl("/profile/logout");
    }

    public static function login(AcceptanceTester $I)
    {
        $I->amOnUrl(self::getLoginUrl());
        $I->seeResponseCodeIs(200);
        $I->seeElement("[name='login-button']");
        $I->fillField("#username", Tester::TEST_USER);
        $I->fillField("#pwd", Tester::TEST_PASS);
        $I->submitForm("#login-form", []);
    }

    public static function getLoginUrl()
    {
        return self::getUrl("/profile/login");
    }

    public static function clearUserParams()
    {
        $users = \models\UserQuery::model()
            ->filterByJsonParams(null, \ActiveRecord\Criteria::ISNOTNULL)
            ->all();
        foreach ($users as $user) {
            $user->json_params = null;
            $user->save(false, ['json_params']);
        }
    }

    public static function clearUploads()
    {
        foreach (\models\UploadsQuery::model()->all() as $upload) {
            $upload->delete();
        }
    }

    public static function getVideoUrl()
    {
        return "https://sheer.com/example.mp4";
    }

    public static function getBrokenUrl()
    {
        return "sdfsdfdfsdf";
    }

    public static function getDataForApi(array $data)
    {
        $salt = \controllers\ApiController::getApiParams('salt');
        return \api\security\Hash::getDataWithHash($salt, $data);
    }

    public static function getUploadsUploadedCount()
    {
        return \models\UploadsQuery::model()->filterByStatusUploaded()->count();
    }

}