<?php

namespace models\forms\settings;

use models\User;

interface Contract
{
    public function loadFromUser(User $user);

    public function saveToUser(User $user);
}