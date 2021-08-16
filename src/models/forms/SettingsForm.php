<?php

namespace models\forms;

use models\forms\base\Form;
use models\forms\base\FormCollection;
use models\forms\settings\Contract;
use models\forms\settings\FtpForm;
use models\forms\settings\IntegrationsForm;
use models\forms\settings\PaxumForm;
use models\forms\settings\ProfileForm;
use models\forms\settings\UserForm;
use models\forms\settings\WireForm;

class SettingsForm extends FormCollection
{

    /**
     * @return SettingsForm
     */
    public static function create()
    {
        return new self();
    }

    public function init()
    {
        $this
            ->addForm(new UserForm())
            ->addForm(new WireForm())
            ->addForm(new PaxumForm())
            ->addForm(new IntegrationsForm())
            ->addForm(new FtpForm())
            ->addForm(new ProfileForm());
    }

    public function loadFromUser(\models\User $user)
    {
        /** @var Contract|Form $form */
        foreach ($this->getForms() as $form) {
            $form->loadFromUser($user);
        }
    }

    public function saveToUser(\models\User $user)
    {
        /** @var Contract|Form $form */
        foreach ($this->getForms() as $form) {
            $form->saveToUser($user);
        }
    }
}