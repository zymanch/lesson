<?php

namespace models\forms\settings;

use models\Country;
use models\forms\base\Form;
use models\PaymentMethod;
use models\User;

class UserForm extends Form implements Contract
{

    const CURRENCY_USD = 'USD';
    const CURRENCY_EUR = 'EUR';
    const CURRENCY_CZK = 'CZK';

    const SETTING_KEY_USER_NAME = 'user_name';
    const SETTING_KEY_USER_ADDRESS = 'user_address';
    const SETTING_KEY_USER_MIN_PAYOUT = 'user_min_payout';
    const SETTING_KEY_USER_PAYOUT_DAY = 'user_payout_day';

    const SETTING_KEY_COMPANY_NAME = 'company_name';
    const SETTING_KEY_COMPANY_ADDRESS = 'company_address';

    const SETTING_KEY_COUNTRY = 'country_id';
    const SETTING_KEY_CURRENCY = 'currency';
    const SETTING_KEY_VAT = 'vat';

    public $user_name;
    public $user_address;
    public $user_min_payout;
    public $user_payout_day;

    public $company_name;
    public $company_address;

    public $country_id;
    public $currency;
    public $vat;

    public static function getDefaultPayoutDay()
    {
        return 25;
    }

    public function rules()
    {
        return [
            [[self::SETTING_KEY_USER_NAME, self::SETTING_KEY_USER_ADDRESS, self::SETTING_KEY_COUNTRY], 'required'],
            [
                [
                    self::SETTING_KEY_USER_NAME,
                    self::SETTING_KEY_USER_ADDRESS,
                    self::SETTING_KEY_COMPANY_NAME,
                    self::SETTING_KEY_COMPANY_ADDRESS,
                ],
                'string',
                'min' => 6,
                'max' => 512,
            ],
            [[self::SETTING_KEY_COUNTRY], 'in', 'range' => array_keys(Country::getVariants())],
            [
                [self::SETTING_KEY_CURRENCY],
                'in',
                'range' => [self::CURRENCY_USD, self::CURRENCY_EUR, self::CURRENCY_CZK],
            ],
            [
                [self::SETTING_KEY_USER_MIN_PAYOUT],
                'integer',
                'min' => PaymentMethod::DEFAULT_MIN_AMOUNT_TO_PAY,
                'max' => PaymentMethod::DEFAULT_MAX_AMOUNT_TO_PAY,
            ],
            [
                [self::SETTING_KEY_USER_PAYOUT_DAY],
                'in',
                'range' => self::getAllowedUserPayoutDays(),
            ],
            [[self::SETTING_KEY_VAT], 'string', 'max' => 128],
        ];
    }

    public static function getAllowedUserPayoutDays()
    {
        return [25, 15, 5];
    }

    public function attributeLabels()
    {
        return [
            self::SETTING_KEY_USER_NAME => 'Your own name (First name / Last name)',
            self::SETTING_KEY_USER_ADDRESS => 'Your own address',
            self::SETTING_KEY_USER_MIN_PAYOUT => 'Your minimum auto payout amount',
            self::SETTING_KEY_USER_PAYOUT_DAY => 'Your auto payout day',

            self::SETTING_KEY_COMPANY_NAME => 'Company name',
            self::SETTING_KEY_COMPANY_ADDRESS => 'Company address',

            self::SETTING_KEY_COUNTRY => 'Your country',
            self::SETTING_KEY_VAT => 'VAT number',
        ];
    }

    public function loadFromUser(User $user)
    {
        $this->user_name = $user->getSetting(self::SETTING_KEY_USER_NAME);
        $this->user_address = $user->getSetting(self::SETTING_KEY_USER_ADDRESS);
        $this->user_min_payout = $user->getSetting(self::SETTING_KEY_USER_MIN_PAYOUT);
        $this->user_payout_day = $user->getSetting(self::SETTING_KEY_USER_PAYOUT_DAY);
        $this->company_name = $user->getSetting(self::SETTING_KEY_COMPANY_NAME);
        $this->company_address = $user->getSetting(self::SETTING_KEY_COMPANY_ADDRESS);
        $this->country_id = $user->getSetting(self::SETTING_KEY_COUNTRY, Country::DEFAULT_COUNTRY_ID);
        $this->currency = $user->getSetting(self::SETTING_KEY_CURRENCY, self::CURRENCY_USD);
        $this->vat = $user->getSetting(self::SETTING_KEY_VAT);
    }

    public function saveToUser(User $user)
    {
        $user
            ->setSetting(self::SETTING_KEY_USER_NAME, $this->user_name)
            ->setSetting(self::SETTING_KEY_USER_ADDRESS, $this->user_address)
            ->setSetting(self::SETTING_KEY_USER_MIN_PAYOUT, $this->user_min_payout)
            ->setSetting(self::SETTING_KEY_USER_PAYOUT_DAY, $this->user_payout_day)
            ->setSetting(self::SETTING_KEY_COMPANY_NAME, $this->company_name)
            ->setSetting(self::SETTING_KEY_COMPANY_ADDRESS, $this->company_address)
            ->setSetting(self::SETTING_KEY_COUNTRY, $this->country_id)
            ->setSetting(self::SETTING_KEY_CURRENCY, $this->currency)
            ->setSetting(self::SETTING_KEY_VAT, $this->vat)
            ->save(false, ['json_params']);
    }

}