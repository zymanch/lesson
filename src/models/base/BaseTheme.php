<?php

namespace models\base;



/**
 * This is the model class for table "lesson.theme".
 *
 * @property integer $theme_id
 * @property integer $lesson_id
 * @property string $name
 * @property integer $position
 *
 * @property \models\LessonDay[] $lessonDays
 * @property \models\Lesson $lesson
 */
class BaseTheme extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lesson.theme';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[BaseThemePeer::LESSON_ID, BaseThemePeer::POSITION], 'integer'],
            [[BaseThemePeer::NAME], 'string', 'max' => 1000],
            [[BaseThemePeer::LESSON_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseLesson::className(), 'targetAttribute' => [BaseThemePeer::LESSON_ID => BaseLessonPeer::LESSON_ID]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseThemePeer::THEME_ID => 'Theme ID',
            BaseThemePeer::LESSON_ID => 'Lesson ID',
            BaseThemePeer::NAME => 'Name',
            BaseThemePeer::POSITION => 'Position',
        ];
    }
    /**
     * @return \models\LessonDayQuery
     */
    public function getLessonDays() {
        return $this->hasMany(\models\LessonDay::className(), [BaseLessonDayPeer::THEME_ID => BaseThemePeer::THEME_ID]);
    }
        /**
     * @return \models\LessonQuery
     */
    public function getLesson() {
        return $this->hasOne(\models\Lesson::className(), [BaseLessonPeer::LESSON_ID => BaseThemePeer::LESSON_ID]);
    }
    
    /**
     * @inheritdoc
     * @return \models\ThemeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \models\ThemeQuery(get_called_class());
    }
}
