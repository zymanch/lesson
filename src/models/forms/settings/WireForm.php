<?php

namespace models\forms\settings;

use models\forms\base\Form;
use models\User;

class WireForm extends Form implements Contract
{

    const SETTING_KEY_ENABLED = 'wire_enabled';
    const SETTING_KEY_BENEFICIARY_NAME = 'wire_beneficiary_name';
    const SETTING_KEY_BENEFICIARY_ADDRESS = 'wire_beneficiary_address';
    const SETTING_KEY_BANK_NAME = 'wire_bank_name';
    const SETTING_KEY_BANK_ADDRESS = 'wire_bank_address';
    const SETTING_KEY_IBAN = 'wire_iban';
    const SETTING_KEY_SWIFT = 'wire_swift';
    const SETTING_KEY_INTERMEDIARY_BANK = 'wire_intermediary_bank';
    const SETTING_KEY_ABA = 'wire_aba';

    public $enabled;
    public $beneficiary_name;
    public $beneficiary_address;
    public $bank_name;
    public $bank_address;
    public $swift;
    public $intermediary_bank;
    public $aba;
    public $iban;

    public function rules()
    {
        return [
            [['enabled'], 'boolean'],
            [
                [
                    'beneficiary_name',
                    'bank_address',
                    'swift',
                    'intermediary_bank',
                    'aba',
                    'iban',
                    'beneficiary_address',
                ],
                'string',
                'min' => 6,
                'max' => 512,
            ],
            [
                [
                    'bank_name',
                ],
                'string',
                'min' => 4,
                'max' => 512,
            ],
        ];
    }

    public function load($data, $formName = null)
    {
        if (!parent::load($data, $formName)) {
            return false;
        }
        $this->enabled = (bool)$this->bank_name;
        return true;
    }

    public function attributeLabels()
    {
        return [
            'beneficiary_name' => 'Beneficiary name',
            'beneficiary_address' => 'Beneficiary address',
            'bank_name' => 'Bank name',
            'bank_address' => 'Bank address',
            'swift' => 'SWIFT code',
            'intermediary_bank' => 'Intermediary bank (optional)',
            'aba' => 'ABA routing number (for US)',
            'iban' => 'Account number / IBAN',
        ];
    }

    public function loadFromUser(User $user)
    {
        $this->enabled = $user->getSetting(self::SETTING_KEY_ENABLED);
        $this->beneficiary_name = $user->getSetting(self::SETTING_KEY_BENEFICIARY_NAME);
        $this->beneficiary_address = $user->getSetting(self::SETTING_KEY_BENEFICIARY_ADDRESS);
        $this->bank_name = $user->getSetting(self::SETTING_KEY_BANK_NAME);
        $this->bank_address = $user->getSetting(self::SETTING_KEY_BANK_ADDRESS);
        $this->swift = $user->getSetting(self::SETTING_KEY_SWIFT);
        $this->intermediary_bank = $user->getSetting(self::SETTING_KEY_INTERMEDIARY_BANK);
        $this->aba = $user->getSetting(self::SETTING_KEY_ABA);
        $this->iban = $user->getSetting(self::SETTING_KEY_IBAN);
    }

    public function saveToUser(User $user)
    {
        $user
            ->setSetting(self::SETTING_KEY_ENABLED, $this->enabled)
            ->setSetting(self::SETTING_KEY_BENEFICIARY_NAME, $this->beneficiary_name)
            ->setSetting(self::SETTING_KEY_BENEFICIARY_ADDRESS, $this->beneficiary_address)
            ->setSetting(self::SETTING_KEY_BANK_NAME, $this->bank_name)
            ->setSetting(self::SETTING_KEY_BANK_ADDRESS, $this->bank_address)
            ->setSetting(self::SETTING_KEY_SWIFT, $this->swift)
            ->setSetting(self::SETTING_KEY_INTERMEDIARY_BANK, $this->intermediary_bank)
            ->setSetting(self::SETTING_KEY_ABA, $this->aba)
            ->setSetting(self::SETTING_KEY_IBAN, $this->iban)
            ->save(false, ['json_params']);
    }
}