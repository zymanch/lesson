<?php

namespace models\forms;

use models\forms\base\Form;
use models\User;
use models\UserQuery;

class TermsForm extends Form
{
    public $comment;
    public $name;
    public $authority;
    
    public function rules()
    {
        return [
            [['comment', 'name', 'authority'], 'required'],
            [['comment', 'name', 'authority'], 'string', 'min' => 3, 'max' => 200],
        ];
    }
    
    public function save()
    {
        $user = UserQuery::model()
                         ->filterByUserId(\Yii::$app->user->identity->user_id)
                         ->one();
        $user->setSetting(User::TERMS_AGREE_KEY, 1);
        $user->setSetting(User::TERMS_NAME_KEY, $this->name);
        $user->setSetting(User::TERMS_AUTHORITY_KEY, $this->authority);
        $user->setSetting(User::TERMS_COMMENT_KEY, $this->comment);
        $user->setSettingIfEmpty(User::TERMS_AGREE_DATE_KEY, date('Y-m-d H:i:s'));
        $saved = $user->save(false, ['json_params']);
        if (!$saved) {
            $this->addErrors($user->getErrorSummary(true));
        }
        return $saved;
    }
    
}