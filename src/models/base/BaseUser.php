<?php

namespace models\base;



/**
 * This is the model class for table "lesson.user".
 *
 * @property integer $user_id
 * @property string $username
 * @property string $description
 *
 * @property \models\Lesson[] $lessons
 */
class BaseUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lesson.user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[BaseUserPeer::USERNAME, BaseUserPeer::DESCRIPTION], 'required'],
            [[BaseUserPeer::USERNAME], 'string', 'max' => 250],
            [[BaseUserPeer::DESCRIPTION], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseUserPeer::USER_ID => 'User ID',
            BaseUserPeer::USERNAME => 'Username',
            BaseUserPeer::DESCRIPTION => 'Description',
        ];
    }
    /**
     * @return \models\LessonQuery
     */
    public function getLessons() {
        return $this->hasMany(\models\Lesson::className(), [BaseLessonPeer::USER_ID => BaseUserPeer::USER_ID]);
    }
    
    /**
     * @inheritdoc
     * @return \models\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \models\UserQuery(get_called_class());
    }
}
