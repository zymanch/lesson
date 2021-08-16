<?php

namespace models\forms\settings;

use models\AccountQuery;
use models\forms\base\Form;
use models\User;

class ProfileForm extends Form implements Contract
{

    public $welcome_text;
    public $headshot;
    public $poster;

    public function loadFromUser(User $user)
    {
        if (!$user->isReleasedOnTour()) {
            return;
        }
        $account = $this->getAccountModel($user);
        $this->welcome_text = $account->welcome_text;
        $this->headshot = $account->headshot;
        $this->poster = $account->poster;
    }

    /**
     * @param User $user
     * @return \models\Account
     * @throws \Exception
     */
    private function getAccountModel(User $user)
    {
        $model = AccountQuery::model()
            ->filterByUserId($user->user_id)
            ->limit(1)
            ->one();
        if (!$model) {
            throw new \Exception("cant find model, user_id=" . $user->user_id);
        }
        return $model;
    }

    public function saveToUser(User $user)
    {
        if (!$user->isReleasedOnTour()) {
            return;
        }
        $account = $this->getAccountModel($user);
        $account->poster = $this->poster;
        $account->headshot = $this->headshot;
        $account->welcome_text = $this->welcome_text;
        if (!$account->save(false)) {
            throw new \Exception("cant save account info");
        }
    }

    public function rules()
    {
        return [
            [
                [
                    'welcome_text',
                    'headshot',
                    'poster',
                ], 'safe',
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'welcome_text' => 'Welcome text',
            'headshot' => 'Headshot',
            'poster' => 'Poster',
        ];
    }
}