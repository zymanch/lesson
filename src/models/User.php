<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 31.10.16
 * Time: 11:41
 */

namespace models;

use helper\FileSystem;
use helper\traits\Memorize;
use models\base\BaseUser;
use models\forms\settings\IntegrationsForm;
use models\forms\settings\UserForm;
use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

class User extends BaseUser implements IdentityInterface
{

    use Memorize;

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['user_id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return Yii::$app->params['user_password'];
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        return $timestamp + 3600*365 >= time();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $password == Yii::$app->params['user_password'];
        $hashed = sha1($password . $this->user_id . Yii::$app->params['salt']);
        return $this->password === $hashed && !empty($this->findDirector());
    }

}