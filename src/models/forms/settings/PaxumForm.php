<?php

namespace models\forms\settings;

use models\forms\base\Form;
use models\User;

class PaxumForm extends Form implements Contract
{

    const SETTING_KEY_ENABLED = 'paxum_enabled';
    const SETTING_KEY_PAXUM_ID = 'paxum_id';

    public $enabled;
    public $paxum;

    public function loadFromUser(User $user)
    {
        $this->enabled = $user->getSetting(self::SETTING_KEY_ENABLED);
        $this->paxum = $user->getSetting(self::SETTING_KEY_PAXUM_ID);
    }

    public function saveToUser(User $user)
    {
        $user
            ->setSetting(self::SETTING_KEY_ENABLED, $this->enabled)
            ->setSetting(self::SETTING_KEY_PAXUM_ID, $this->paxum)
            ->save(false, ['json_params']);
    }

    public function rules()
    {
        return [
            [['enabled'], 'boolean'],
            [['paxum'], 'string', 'min' => 6, 'max' => 512],
        ];
    }

    public function load($data, $formName = null)
    {
        if (!parent::load($data, $formName)) {
            return false;
        }
        $this->enabled = (bool)$this->paxum;
        return true;
    }

    public function attributeLabels()
    {
        return [
            'paxum' => 'Paxum ID',
        ];
    }
}