<?php

namespace models\forms\settings;

use models\forms\base\Form;
use models\User;

/**
 * Class IntegrationsForm
 *
 * @package models\forms\settings
 */
class IntegrationsForm extends Form implements Contract
{
    const ONLYFANS_URL = 'https://onlyfans.com/';
    const SETTING_KEY_ONLYFANS = 'onlyfans';
    const SETTING_KEY_ONLYFANS_AUTO_RELEASE = 'onlyfans_auto_release';

    public $onlyfans;
    public $onlyfans_auto_release = false;

    public function rules()
    {
        return [
            [
                [
                    self::SETTING_KEY_ONLYFANS,
                ],
                'string',
            ],
            [
                self::SETTING_KEY_ONLYFANS,
                'match',
                'pattern' => '#^[A-z0-9\-_\.]+$#i',
            ],
            [
                [
                    self::SETTING_KEY_ONLYFANS_AUTO_RELEASE,
                ],
                'boolean',
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            self::SETTING_KEY_ONLYFANS => 'Onlyfans profile url',
            self::SETTING_KEY_ONLYFANS_AUTO_RELEASE => 'Auto-release all Onlyfans content on Sheer',
        ];
    }

    public function loadFromUser(User $user)
    {
        $this->onlyfans = $user->getSetting(self::SETTING_KEY_ONLYFANS);
        $this->onlyfans_auto_release = $user->getSetting(self::SETTING_KEY_ONLYFANS_AUTO_RELEASE);
    }

    public function saveToUser(User $user)
    {
        if (!empty($this->onlyfans)) {
            $user->setSetting(self::SETTING_KEY_ONLYFANS, $this->onlyfans);
        }
        $user->setSetting(self::SETTING_KEY_ONLYFANS_AUTO_RELEASE, boolval($this->onlyfans_auto_release));
        $user->save(false, ['json_params']);
    }

}